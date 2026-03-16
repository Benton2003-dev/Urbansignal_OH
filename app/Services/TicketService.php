<?php

namespace App\Services;

use App\Models\Report;

class TicketService
{
    public static function generate(): string
    {
        $year   = now()->format('Y');
        $prefix = 'US-' . $year . '-';
        $last   = Report::where('ticket_number', 'like', $prefix . '%')
                        ->orderByDesc('id')
                        ->first();

        $seq = $last ? ((int) substr($last->ticket_number, -5)) + 1 : 1;

        return $prefix . str_pad($seq, 5, '0', STR_PAD_LEFT);
    }
}
