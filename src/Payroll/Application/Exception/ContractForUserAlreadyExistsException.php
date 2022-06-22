<?php

declare(strict_types=1);

namespace App\Payroll\Application\Exception;

class ContractForUserAlreadyExistsException extends \Exception
{
    public function __construct(string $message = '', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function create(string $userId)
    {
        return new self(message: \sprintf('Contract exists for user: %s', $userId));
    }
}
