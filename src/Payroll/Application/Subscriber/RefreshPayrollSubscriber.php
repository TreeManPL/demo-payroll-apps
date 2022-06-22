<?php

declare(strict_types=1);

namespace App\Payroll\Application\Subscriber;

use App\Employee\Application\Api\EmployeeApi;
use App\Payroll\Domain\Entity\PayrollProjection;
use App\Payroll\Domain\Factory\PayrollProjectionFactory;
use App\Payroll\Domain\Repository\ContractRepositoryInterface;
use App\Payroll\Domain\Repository\PayrollProjectionRepositoryInterface;
use App\Payroll\Domain\Service\DepartmentBonus\BonusCalculator;
use App\Shared\Application\Event\RefreshPayrollEvent;

final class RefreshPayrollSubscriber
{
    public function __construct(
        private readonly ContractRepositoryInterface $contractRepository,
        private readonly PayrollProjectionRepositoryInterface $projectionRepository,
        private readonly EmployeeApi $employeeApi,
        private readonly BonusCalculator $bonusCalculator,
        private readonly PayrollProjectionFactory $factory,
    ) {
    }

    public function __invoke(RefreshPayrollEvent $event)
    {
        $contract = $this->contractRepository->findByUserId($event->userId);
        $payroll = $this->projectionRepository->findByUserId($event->userId);

        $bonusSalary = $this->bonusCalculator->calculate($contract);
        $bonusType = $contract->getDepartmentBonus()?->getType()?->value ?? '-';

        $payroll = match ($payroll) {
            null => $this->initPayroll($event->userId, $contract->getSalary(), $bonusSalary, $bonusType),
            default => $this->updatePayroll($payroll, $contract->getSalary(), $bonusSalary, $bonusType)
        };

        $this->projectionRepository->save($payroll);
    }

    private function initPayroll(string $userId, int $salary, int $bonusSalary, string $bonusType): PayrollProjection
    {
        $employee = $this->employeeApi->findEmployeeDetails($userId);

        return $this->factory->create(
            $userId,
            $employee?->firstName ?? '-',
            $employee?->lastName ?? '-',
            $employee?->departmentName ?? '-',
            $salary,
            $bonusSalary,
            $bonusType
        );
    }

    private function updatePayroll(PayrollProjection $payrollProjection, int $salary, int $bonusSalary, string $bonusType): PayrollProjection
    {
        $payrollProjection->changeProjectionSallary($salary, $bonusSalary, $bonusType);

        return $payrollProjection;
    }
}
