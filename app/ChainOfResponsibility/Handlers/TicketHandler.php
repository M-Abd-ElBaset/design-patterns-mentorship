<?php

namespace App\ChainOfResponsibility\Handlers;

use App\ChainOfResponsibility\Enums\TicketStatus;
use App\ChainOfResponsibility\Ticket;

abstract class TicketHandler
{
    protected ?TicketHandler $next = null;

    public function setNext(TicketHandler $handler): TicketHandler
    {
        $this->next = $handler;

        return $handler;
    }

    abstract protected function label(): string;

    abstract protected function canHandle(Ticket $ticket): bool;

    abstract protected function process(Ticket $ticket): void;

    public function handle(Ticket $ticket): bool
    {
        if ($this->canHandle($ticket)) {
            $ticket->status = TicketStatus::IN_PROGRESS;
            $this->process($ticket);

            return true;
        }

        if ($this->next) {
            info("[{$this->label()}] Cannot handle {$ticket->id}, passing to next...");

            return $this->next->handle($ticket);
        }

        $ticket->status = TicketStatus::ESCALATED;
        info("Ticket {$ticket->id} reached end of chain unhandled -> Status: ESCALATED");

        return false;
    }
}
