<?php

namespace App\ChainOfResponsibility\Enums;

enum TicketCategory
{
    case ACCOUNT;
    case TECHNICAL;
    case BUG;
    case BUSINESS;
}
