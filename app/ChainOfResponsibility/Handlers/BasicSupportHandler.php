<?php

namespace App\ChainOfResponsibility\Handlers;

use App\ChainOfResponsibility\Enums\TicketCategory;
use App\ChainOfResponsibility\Enums\TicketPriority;
use App\ChainOfResponsibility\Ticket;

class BasicSupportHandler extends TicketHandler
{
    public function handle(Ticket $ticket): bool
    {
        if($ticket->priority == TicketPriority::LOW && $ticket->category == TicketCategory::ACCOUNT)
        {
            info("Basic Support: ticket with description: {$ticket->description} has been handled");
            return true;
        }

            return parent::handle($ticket);
    }
}
