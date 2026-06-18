<?php

namespace App\ChainOfResponsibility\Enums;

enum TicketPriority
{
    case LOW;
    case MEDIUM;
    case HIGH;
    case CRITICAL;
}
