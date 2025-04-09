<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            // Admins will see only non-deleted tickets
            $tickets = Ticket::select('tickets.*', 'users.name as user_name')
                ->join('users', 'tickets.user_id', '=', 'users.id')
                ->where('tickets.admin_delete', 0) // Ensures admin sees only non-deleted tickets
                ->orderBy('tickets.created_at', 'desc')
                ->get();
        } else {
            // Users will see their tickets, including soft-deleted ones
            $tickets = Ticket::select('tickets.*', 'users.name as user_name')
                ->join('users', 'tickets.user_id', '=', 'users.id')
                ->forUser(auth()->id()) // Fetch both active and soft-deleted tickets for the user
                ->orderBy('tickets.created_at', 'desc')
                ->get();
        }
    
        return Inertia::render('Dashboard', [
            'tickets' => $tickets,
            'can' => [
                'create_ticket' => true,
                'edit_ticket' => auth()->user()->role === 'admin',
                'delete_ticket' => auth()->user()->role === 'admin'
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('Tickets/Create', [
            'isAdmin' => auth()->user()->role === 'admin'
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:tech_issues,billing_concerns,general_inquiry',
        ]);

        Ticket::create([
            'user_id' => $request->user()->id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'status' => 'Open',
            'priority' => 'low' // Default priority
        ]);

        return redirect()->route('dashboard')->with('success', 'Ticket created successfully!');
    }

    public function edit(Ticket $ticket)
    {
        if (!auth()->user()->isAdmin() && $ticket->user_id !== auth()->id()) {
            abort(403);
        }

        return Inertia::render('Tickets/Edit', [
            'ticket' => $ticket,
        ]);
    }

    public function update(Request $request, Ticket $ticket)
    {
        // Authorization check - only admins can update
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'priority' => 'sometimes|required|in:low,medium,high',
            'status' => 'sometimes|required|in:Open,In Progress,Resolved'
        ]);

        $ticket->update($validated);
        
        return redirect()->route('dashboard')->with('success', 'Ticket updated successfully');
    }

    public function softDelete(Ticket $ticket)
    {
        // Ensure the user is either an admin or the owner of the ticket
        if (auth()->user()->role !== 'admin' && auth()->id() !== $ticket->user_id) {
            abort(403); // Unauthorized action
        }
    
        // Mark the ticket as deleted by setting the `admin_delete` flag to 1
        $ticket->admin_delete = 1;
        $ticket->save();
        
        return redirect()->route('dashboard')->with('success', 'Ticket marked as deleted successfully');
}
    // Permanent delete (removes the ticket from the database)
    public function permanentlyDelete(Ticket $ticket)
    {
        try {
            $ticket->delete(); // Permanently delete the ticket
            return response()->json(['message' => 'Ticket permanently deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete the ticket.', 'error' => $e->getMessage()], 500);
        }
    }
}