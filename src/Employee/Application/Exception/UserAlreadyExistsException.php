<?php

namespace App\Employee\Application\Exception;

final class UserAlreadyExistsException extends \Exception
{
    public static function create(string $id): self
    {
        return new self(message: \sprintf('User with %s not exists', $id));
    }
}
