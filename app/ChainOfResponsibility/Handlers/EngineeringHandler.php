<?php

namespace App\ChainOfResponsibility\Handlers;

use App\ChainOfResponsibility\Enums\TicketCategory;
use App\ChainOfResponsibility\Enums\TicketPriority;
use App\ChainOfResponsibility\Enums\TicketStatus;
use App\ChainOfResponsibility\Ticket;

class EngineeringHandler extends TicketHandler
{
    public function handle(Ticket $ticket): bool
    {
        if(
            $ticket->priority == TicketPriority::HIGH &&
            in_array($ticket->category, [TicketCategory::TECHNICAL, TicketCategory::BUG])
        )
        {
            $ticket->status = TicketStatus::RESOLVED;
            info("Engineering: ticket with description: {$ticket->description} has been handled");
            return true;
        }

            return parent::handle($ticket);
    }
}
