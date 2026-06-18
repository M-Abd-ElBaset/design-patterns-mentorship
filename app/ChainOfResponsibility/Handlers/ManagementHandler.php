<?php

namespace App\ChainOfResponsibility\Handlers;

use App\ChainOfResponsibility\Enums\TicketCategory;
use App\ChainOfResponsibility\Enums\TicketPriority;
use App\ChainOfResponsibility\Ticket;

class ManagementHandler extends TicketHandler
{
    public function handle(Ticket $ticket): bool
    {
        if($ticket->priority == TicketPriority::HIGH &&
            in_array($ticket->category, [TicketCategory::TECHNICAL, TicketCategory::BUG])
        )
        {
            info("Engineering: ticket with description: {$ticket->description} has been handled");
            return true;
        }

            return parent::handle($ticket);
    }
}
