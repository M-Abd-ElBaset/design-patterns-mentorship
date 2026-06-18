<?php

namespace App\ChainOfResponsibility\Handlers;

use App\ChainOfResponsibility\Enums\TicketCategory;
use App\ChainOfResponsibility\Enums\TicketPriority;
use App\ChainOfResponsibility\Enums\TicketStatus;
use App\ChainOfResponsibility\Ticket;

class EngineeringHandler extends TicketHandler
{
    protected function label(): string
    {
        return 'Engineering';
    }

    protected function canHandle(Ticket $ticket): bool
    {
        return $ticket->priority === TicketPriority::HIGH
            && in_array($ticket->category, [TicketCategory::TECHNICAL, TicketCategory::BUG], true);
    }

    protected function process(Ticket $ticket): void
    {
        $ticket->status = TicketStatus::RESOLVED;
        info("[Engineering] Handling ticket {$ticket->id}: {$ticket->description} -> Status: RESOLVED");
    }
}
