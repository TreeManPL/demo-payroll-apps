<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Service;

use App\Shared\Application\Service\IdGeneratorInterface;
use Ramsey\Uuid\Uuid;

class IdGenerator implements IdGeneratorInterface
{
    public function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}
