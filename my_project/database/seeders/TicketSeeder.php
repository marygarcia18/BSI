<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ticket;

class TicketSeeder extends Seeder
{
    public function run()
    {
        Ticket::create([
            'title' => 'Sample Ticket 1',
        ]);

        Ticket::create([
            'title' => 'Sample Ticket 2',
        ]);
    }
}
