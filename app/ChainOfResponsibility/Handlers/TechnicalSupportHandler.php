<?php

namespace App\ChainOfResponsibility\Handlers;

use App\ChainOfResponsibility\Enums\TicketCategory;
use App\ChainOfResponsibility\Enums\TicketPriority;
use App\ChainOfResponsibility\Enums\TicketStatus;
use App\ChainOfResponsibility\Ticket;

class TechnicalSupportHandler extends TicketHandler
{
    protected function label(): string
    {
        return 'TechnicalSupport';
    }

    protected function canHandle(Ticket $ticket): bool
    {
        return in_array($ticket->priority, [TicketPriority::LOW, TicketPriority::MEDIUM], true)
            && in_array($ticket->category, [TicketCategory::TECHNICAL, TicketCategory::BUG], true);
    }

    protected function process(Ticket $ticket): void
    {
        $ticket->status = TicketStatus::RESOLVED;
        info("[TechnicalSupport] Handling ticket {$ticket->id}: {$ticket->description} -> Status: RESOLVED");
    }
}
