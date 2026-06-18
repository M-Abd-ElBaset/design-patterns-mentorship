<?php

namespace App\ChainOfResponsibility;

use App\ChainOfResponsibility\Enums\TicketCategory;
use App\ChainOfResponsibility\Enums\TicketPriority;
use App\ChainOfResponsibility\Enums\TicketStatus;

class Ticket
{
    public string $id;
    public string $customer;
    public TicketPriority $priority;
    public TicketCategory $category;
    public string $description;
    public TicketStatus $status;
}
