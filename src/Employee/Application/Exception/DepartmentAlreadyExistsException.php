<?php

declare(strict_types=1);

namespace App\Employee\Application\Exception;

final class DepartmentAlreadyExistsException extends \Exception
{
    public static function create(string $id)
    {
        return new self(message: \sprintf('Department with %s already exists', $id));
    }
}
