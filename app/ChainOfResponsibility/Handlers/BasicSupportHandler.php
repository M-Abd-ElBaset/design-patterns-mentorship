<?php

namespace App\ChainOfResponsibility\Handlers;

use App\ChainOfResponsibility\Enums\TicketCategory;
use App\ChainOfResponsibility\Enums\TicketPriority;
use App\ChainOfResponsibility\Enums\TicketStatus;
use App\ChainOfResponsibility\Ticket;

class BasicSupportHandler extends TicketHandler
{
    protected function label(): string
    {
        return 'BasicSupport';
    }

    protected function canHandle(Ticket $ticket): bool
    {
        return $ticket->priority === TicketPriority::LOW
            && $ticket->category === TicketCategory::ACCOUNT;
    }

    protected function process(Ticket $ticket): void
    {
        $ticket->status = TicketStatus::RESOLVED;
        info("[BasicSupport] Handling ticket {$ticket->id}: {$ticket->description} -> Status: RESOLVED");
    }
}
