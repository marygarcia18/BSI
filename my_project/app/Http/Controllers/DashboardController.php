<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        return Inertia::render('Dashboard', [
            'isAdmin' => $user->role === 'admin',
            'tickets' => $user->role === 'admin' ? Ticket::latest()->get() : null,
            'userTickets' => $user->tickets()->latest()->get(),
            'canCreate' => $user->role === 'admin'
        ]);
    }
}