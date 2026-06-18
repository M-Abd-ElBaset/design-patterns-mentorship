<?php

namespace App\ChainOfResponsibility;

use App\ChainOfResponsibility\Enums\TicketCategory;
use App\ChainOfResponsibility\Enums\TicketPriority;
use App\ChainOfResponsibility\Enums\TicketStatus;

class Ticket
{
    public function __construct(
        public string $id,
        public string $customerName,
        public TicketPriority $priority,
        public TicketCategory $category,
        public string $description,
        public TicketStatus $status = TicketStatus::PENDING,
    ) {
    }
}
