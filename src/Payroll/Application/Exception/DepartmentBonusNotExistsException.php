<?php

declare(strict_types=1);

namespace App\Payroll\Application\Exception;

class DepartmentBonusNotExistsException extends \Exception
{
    public function __construct(string $message = '', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function create(string $departmentId): self
    {
        return new self(message: \sprintf('Department bonus not exists for department: %s', $departmentId));
    }
}
