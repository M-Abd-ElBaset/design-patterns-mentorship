<?php

namespace App\ChainOfResponsibility\Handlers;

use App\ChainOfResponsibility\Ticket;

abstract class TicketHandler
{
    protected ?TicketHandler $next = null;
    public function setNext(TicketHandler $handler): TicketHandler
    {
        $this->next = $handler;
        return $this;
    }
    public function handle(Ticket $ticket): bool
    {
        if($this->next){
            return $this->next->handle($ticket);
        }

        info("Ticket with description: {$ticket->description} couldn't be handled");

        return false;
    }

}
