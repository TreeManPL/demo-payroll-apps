<?php

namespace App\Employee\Application\Exception;

final class DepartmentNotExistsException extends \Exception
{
    public static function create(string $id)
    {
        return new self(message: \sprintf('Department with %s not exists', $id));
    }
}
