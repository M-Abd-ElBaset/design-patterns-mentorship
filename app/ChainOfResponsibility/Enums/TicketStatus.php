<?php

namespace App\ChainOfResponsibility\Enums;

enum TicketStatus
{
    case PENDING;
    case IN_PROGRESS;
    case RESOLVED;
    case ESCALATED;
}
