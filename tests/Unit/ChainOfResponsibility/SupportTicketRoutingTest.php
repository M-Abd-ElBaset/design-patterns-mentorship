<?php

namespace Tests\Unit\ChainOfResponsibility;

use App\ChainOfResponsibility\Enums\TicketCategory;
use App\ChainOfResponsibility\Enums\TicketPriority;
use App\ChainOfResponsibility\Enums\TicketStatus;
use App\ChainOfResponsibility\Handlers\BasicSupportHandler;
use App\ChainOfResponsibility\Handlers\EngineeringHandler;
use App\ChainOfResponsibility\Handlers\ManagementHandler;
use App\ChainOfResponsibility\Handlers\TechnicalSupportHandler;
use App\ChainOfResponsibility\Ticket;
use Tests\TestCase;

class SupportTicketRoutingTest extends TestCase
{
    public function test_basic_support_handles_low_account_ticket(): void
    {
        $handler = $this->buildFullChain();
        $ticket = $this->ticket(
            id: 'T001',
            priority: TicketPriority::LOW,
            category: TicketCategory::ACCOUNT,
            description: 'Forgot password'
        );

        $handled = $handler->handle($ticket);

        $this->assertTrue($handled);
        $this->assertSame(TicketStatus::RESOLVED, $ticket->status);
    }

    public function test_ticket_moves_to_engineering_when_lower_levels_cannot_handle_it(): void
    {
        $handler = $this->buildFullChain();
        $ticket = $this->ticket(
            id: 'T002',
            priority: TicketPriority::HIGH,
            category: TicketCategory::BUG,
            description: 'App crashes on login'
        );

        $handled = $handler->handle($ticket);

        $this->assertTrue($handled);
        $this->assertSame(TicketStatus::RESOLVED, $ticket->status);
    }

    public function test_critical_ticket_reaches_management(): void
    {
        $handler = $this->buildFullChain();
        $ticket = $this->ticket(
            id: 'T003',
            priority: TicketPriority::CRITICAL,
            category: TicketCategory::BUSINESS,
            description: 'VIP client data breach'
        );

        $handled = $handler->handle($ticket);

        $this->assertTrue($handled);
        $this->assertSame(TicketStatus::ESCALATED, $ticket->status);
    }

    public function test_ticket_is_escalated_when_chain_ends_unhandled(): void
    {
        $handler = $this->buildNoManagementChain();
        $ticket = $this->ticket(
            id: 'T004',
            priority: TicketPriority::MEDIUM,
            category: TicketCategory::BUSINESS,
            description: 'Invoice question'
        );

        $handled = $handler->handle($ticket);

        $this->assertFalse($handled);
        $this->assertSame(TicketStatus::ESCALATED, $ticket->status);
    }

    public function test_chain_can_skip_technical_support_at_runtime(): void
    {
        $handler = (new BasicSupportHandler())
            ->setNext(new EngineeringHandler())
            ->setNext(new ManagementHandler());

        $ticket = $this->ticket(
            id: 'T005',
            priority: TicketPriority::MEDIUM,
            category: TicketCategory::TECHNICAL,
            description: 'Integration timeout'
        );

        $handled = $handler->handle($ticket);

        $this->assertTrue($handled);
        $this->assertSame(TicketStatus::ESCALATED, $ticket->status);
    }

    private function buildFullChain(): BasicSupportHandler
    {
        $basic = new BasicSupportHandler();
        $technical = $basic->setNext(new TechnicalSupportHandler());
        $engineering = $technical->setNext(new EngineeringHandler());
        $engineering->setNext(new ManagementHandler());

        return $basic;
    }

    private function buildNoManagementChain(): BasicSupportHandler
    {
        $basic = new BasicSupportHandler();
        $technical = $basic->setNext(new TechnicalSupportHandler());
        $technical->setNext(new EngineeringHandler());

        return $basic;
    }

    private function ticket(
        string $id,
        TicketPriority $priority,
        TicketCategory $category,
        string $description
    ): Ticket {
        return new Ticket(
            id: $id,
            customerName: 'Acme Corp',
            priority: $priority,
            category: $category,
            description: $description
        );
    }
}
