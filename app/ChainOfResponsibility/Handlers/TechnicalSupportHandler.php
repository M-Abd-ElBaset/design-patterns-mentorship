<?php

namespace App\ChainOfResponsibility\Handlers;

use App\ChainOfResponsibility\Enums\TicketCategory;
use App\ChainOfResponsibility\Enums\TicketPriority;
use App\ChainOfResponsibility\Ticket;

class TechnicalSupportHandler extends TicketHandler
{
    public function handle(Ticket $ticket): bool
    {
        if(
            in_array($ticket->priority, [TicketPriority::LOW, TicketPriority::MEDIUM]) &&
            in_array($ticket->category, [TicketCategory::TECHNICAL, TicketCategory::BUG])
        )
        {
            info("Technical Support: ticket with description: {$ticket->description} has been handled");
            return true;
        }

            return parent::handle($ticket);
    }
}
