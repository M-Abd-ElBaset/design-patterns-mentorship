<?php

namespace App\ChainOfResponsibility\Handlers;

use App\ChainOfResponsibility\Enums\TicketPriority;
use App\ChainOfResponsibility\Enums\TicketStatus;
use App\ChainOfResponsibility\Ticket;

class ManagementHandler extends TicketHandler
{
    protected function label(): string
    {
        return 'Management';
    }

    protected function canHandle(Ticket $ticket): bool
    {
        return true;
    }

    protected function process(Ticket $ticket): void
    {
        $ticket->status = TicketStatus::ESCALATED;

        $priorityLabel = $ticket->priority === TicketPriority::CRITICAL ? 'CRITICAL ' : '';

        info("[Management] Handling {$priorityLabel}ticket {$ticket->id}: {$ticket->description} -> Status: ESCALATED");
    }
}
