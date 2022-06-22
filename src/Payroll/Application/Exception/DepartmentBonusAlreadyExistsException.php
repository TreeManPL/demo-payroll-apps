<?php

declare(strict_types=1);

namespace App\Payroll\Application\Exception;

class DepartmentBonusAlreadyExistsException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function create(string $departmentId)
    {
        return new self(message:\sprintf('Department bonus exists for department: %s', $departmentId));
    }
}
