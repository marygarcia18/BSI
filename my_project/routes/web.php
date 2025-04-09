<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Models\Ticket;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        // 'laravelVersion' => Application::VERSION,
        // 'phpVersion' => PHP_VERSION,
    ]);
});

Route::patch('/tickets/{ticket}/delete', [TicketController::class, 'softDelete'])->name('tickets.softDelete');
// Route::delete('/tickets/permanently/{ticket}', [TicketController::class, 'permanentlyDelete'])->name('tickets.permanentlyDelete');
Route::delete('/ticket/permanently/{ticket}', [TicketController::class, 'permanentlyDelete'])->name('ticket.permanentlyDelete');

Route::middleware(['auth'])->group(function () {
    // Dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ticket routes - accessible by all authenticated users
    Route::resource('tickets', TicketController::class);

    Route::get('/tickets/{ticket}/view', function (Ticket $ticket) {
        return Inertia::render('Tickets/View', [
            'ticket' => $ticket,
        ]);
    })->name('tickets.view');

    // Route::get('/tickets/{ticket}/create', function (Ticket $ticket) {
    //     return Inertia::render('Tickets/Create', [
    //         'ticket' => $ticket,
    //     ]);
    // })->name('tickets.create');

    

});

// Registration routes
Route::get('register', [RegisteredUserController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisteredUserController::class, 'register']);

require __DIR__.'/auth.php';