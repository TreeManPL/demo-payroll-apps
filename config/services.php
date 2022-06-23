<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Employee\Application\Api\EmployeeApi;
use App\Employee\Application\Command\Deprtment\CreateDepartmentHandler;
use App\Employee\Application\Command\User\CreateUserHandler;
use App\Employee\Domain\Factory\DepartmentFactory;
use App\Employee\Domain\Factory\UserFactory;
use App\Employee\Domain\Repository\DepartmentRepositoryInterface;
use App\Employee\Domain\Repository\UserRepositoryInterface;
use App\Employee\Infrastructure\Repository\DepartmentRepository;
use App\Employee\Infrastructure\Repository\UserRepository;
use App\Payroll\Application\Command\Contract\AddBonusToContractHandler;
use App\Payroll\Application\Command\Contract\CreateContractHandler;
use App\Payroll\Application\Command\Contract\UpdateContractHandler;
use App\Payroll\Application\Command\DepartmentBonus\CreateDepartmentBonusHandler;
use App\Payroll\Application\Command\DepartmentBonus\UpdateDepartmentBonusHandler;
use App\Payroll\Application\Query\FindPayrollsHandler;
use App\Payroll\Application\Subscriber\DepartmentBonusWasCreatedSubscriber;
use App\Payroll\Application\Subscriber\DepartmentBonusWasUpdatedSubscriber;
use App\Payroll\Application\Subscriber\RefreshPayrollSubscriber;
use App\Payroll\Domain\Factory\ContractFactory;
use App\Payroll\Domain\Factory\DepartmentBonusFactory;
use App\Payroll\Domain\Factory\PayrollProjectionFactory;
use App\Payroll\Domain\Repository\ContractRepositoryInterface;
use App\Payroll\Domain\Repository\DepartmentBonusRepositoryInterface;
use App\Payroll\Domain\Repository\PayrollProjectionRepositoryInterface;
use App\Payroll\Domain\Service\DepartmentBonus\BonusCalculator;
use App\Payroll\Domain\Service\DepartmentBonus\FixedBonusStrategy;
use App\Payroll\Domain\Service\DepartmentBonus\PercentBonusStrategy;
use App\Payroll\Infrastructure\Console\RefreshAllContractsPayrollProjections;
use App\Payroll\Infrastructure\Repository\ContractRepository;
use App\Payroll\Infrastructure\Repository\DepartmentBonusRepository;
use App\Payroll\Infrastructure\Repository\PayrollProjectionRepository;
use App\Payroll\Infrastructure\UI\CreateContract;
use App\Payroll\Infrastructure\UI\CreateDepartmentBonus;
use App\Payroll\Infrastructure\UI\GetPayrolls;
use App\Payroll\Infrastructure\UI\UpdateContract;
use App\Payroll\Infrastructure\UI\UpdateDepartmentBonus;
use App\Shared\Application\Api\User\EmployeeApiInterface;
use App\Shared\Application\Command\CommandBusInterface;
use App\Shared\Application\Event\EventBusInterface;
use App\Shared\Application\Query\QueryBusInterface;
use App\Shared\Application\Service\IdGeneratorInterface;
use App\Shared\Infrastructure\Bus\CatchPreviousExceptionMiddleware;
use App\Shared\Infrastructure\Bus\CommandBus;
use App\Shared\Infrastructure\Bus\EventBus;
use App\Shared\Infrastructure\Bus\QueryBus;
use App\Shared\Infrastructure\Service\IdGenerator;

return static function (ContainerConfigurator $configurator): void {
    $services = $configurator
        ->services()
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->private();

    // Shared Services
    $services->set(CommandBus::class);
    $services->alias(CommandBusInterface::class, CommandBus::class);
    $services->set(CatchPreviousExceptionMiddleware::class);
    $services->alias('catch_previous_exception.middleware', CatchPreviousExceptionMiddleware::class);

    $services->set(EventBus::class);
    $services->alias(EventBusInterface::class, EventBus::class);

    $services->instanceof(EventBusInterface::class)
        ->tag('messenger.message_handler', ['bus' => 'event.bus']);

    $services->set(QueryBus::class);
    $services->alias(QueryBusInterface::class, QueryBus::class);

    $services->instanceof(QueryBusInterface::class)
        ->tag('messenger.message_handler', ['bus' => 'query.bus']);

    $services->set(IdGenerator::class);
    $services->alias(IdGeneratorInterface::class, IdGenerator::class);

    $services->alias(EmployeeApiInterface::class, EmployeeApi::class)
        ->public();

    // Employee context
    $services->set(EmployeeApi::class);

    $services->set(UserRepository::class);
    $services->alias(UserRepositoryInterface::class, UserRepository::class);

    $services->set(DepartmentRepository::class);
    $services->alias(DepartmentRepositoryInterface::class, DepartmentRepository::class);

    // command handlers
    $services->set(CreateDepartmentHandler::class)
        ->tag('messenger.message_handler');
    $services->set(CreateUserHandler::class)
        ->tag('messenger.message_handler');

    $services->set(DepartmentFactory::class);
    $services->set(UserFactory::class);

    // Payroll context
    $services->set(ContractRepository::class);
    $services->alias(ContractRepositoryInterface::class, ContractRepository::class);
    $services->set(DepartmentBonusRepository::class);
    $services->alias(DepartmentBonusRepositoryInterface::class, DepartmentBonusRepository::class);
    $services->set(PayrollProjectionRepository::class);
    $services->alias(PayrollProjectionRepositoryInterface::class, PayrollProjectionRepository::class);

    $services->set(ContractFactory::class);
    $services->set(DepartmentBonusFactory::class);
    $services->set(PayrollProjectionFactory::class);

    $services->set(FixedBonusStrategy::class)
        ->tag('app.department_bonus.calculate_strategy');
    $services->set(PercentBonusStrategy::class)
        ->tag('app.department_bonus.calculate_strategy');

    $services->set(BonusCalculator::class)
        ->args([tagged_iterator('app.department_bonus.calculate_strategy')])
        ->public();

    // controllers
    $services->set(CreateContract::class)
        ->tag('controller.service_arguments');
    $services->set(UpdateContract::class)
        ->tag('controller.service_arguments');
    $services->set(CreateDepartmentBonus::class)
        ->tag('controller.service_arguments');
    $services->set(UpdateDepartmentBonus::class)
        ->tag('controller.service_arguments');
    $services->set(GetPayrolls::class)
        ->tag('controller.service_arguments');

    // command handlers
    $services->set(CreateContractHandler::class)
        ->tag('messenger.message_handler');
    $services->set(UpdateContractHandler::class)
        ->tag('messenger.message_handler');
    $services->set(CreateDepartmentBonusHandler::class)
        ->tag('messenger.message_handler');
    $services->set(UpdateDepartmentBonusHandler::class)
        ->tag('messenger.message_handler');
    $services->set(AddBonusToContractHandler::class)
        ->tag('messenger.message_handler');

    // event handlers
    $services->set(DepartmentBonusWasCreatedSubscriber::class)
        ->tag('messenger.message_handler');
    $services->set(DepartmentBonusWasUpdatedSubscriber::class)
        ->tag('messenger.message_handler');
    $services->set(RefreshPayrollSubscriber::class)
        ->tag('messenger.message_handler');

    // query handlers
    $services->set(FindPayrollsHandler::class)
        ->tag('messenger.message_handler');

    // console
    $services->set(RefreshAllContractsPayrollProjections::class);
};
