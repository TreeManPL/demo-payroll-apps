<?php

declare(strict_types=1);

namespace App\Shared\Application\Event;

class RefreshPayrollEvent implements EventInterface, AsyncEventInterface
{
    public function __construct(public readonly string $userId)
    {
    }
}
