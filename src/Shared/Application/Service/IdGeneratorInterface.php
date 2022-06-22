<?php

declare(strict_types=1);

namespace App\Shared\Application\Service;

interface IdGeneratorInterface
{
    public function generate(): string;
}
