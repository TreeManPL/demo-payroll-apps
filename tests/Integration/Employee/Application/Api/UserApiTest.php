<?php

declare(strict_types=1);

namespace App\Tests\Integration\Employee\Application\Api;

use App\Employee\Application\Api\EmployeeApi;
use App\Employee\Application\Command\Deprtment\CreateDepartmentCommand;
use App\Employee\Application\Command\User\CreateUserCommand;
use App\Shared\Application\Command\CommandBusInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserApiTest extends KernelTestCase
{
    private CommandBusInterface $commandBus;
    private EmployeeApi $employeeApi;

    public function setUp(): void
    {
        parent::setUp();

        $this->commandBus = static::getContainer()->get(CommandBusInterface::class);
        $this->employeeApi = static::getContainer()->get(EmployeeApi::class);
    }

    /**
     * @test
     */
    public function getUserByIdSuccessfully(): void
    {
        // given
        $userId = '3ec388e7-269f-45f0-ab31-943a5aeb9bb3';
        $command = new CreateUserCommand(
            $userId,
            'First Name',
            'Last Name',
            null
        );

        $this->commandBus->run($command);

        // when
        $employeeDetails = $this->employeeApi->findEmployeeDetails($userId);

        // then
        $this->assertNotNull($employeeDetails);
    }

    /**
     * @test
     */
    public function getUsersByDepartmentId(): void
    {
        // given
        $departmentId = 'f58f17a6-c557-4661-bad4-de0d71e72949';
        $command = new CreateDepartmentCommand(
            $departmentId,
            'Test Department Two'
        );

        // when
        $this->commandBus->run($command);

        $userId = 'ab5472c8-af20-4bce-8d87-dd4ff9ee56ef';
        $command = new CreateUserCommand(
            $userId,
            'First Name',
            'Last Name',
            $departmentId
        );
        $this->commandBus->run($command);

        $userId = 'fcf64a47-0d34-43c7-8edc-d800c339c407';
        $command = new CreateUserCommand(
            $userId,
            'First Name two',
            'Last Name two',
            $departmentId
        );
        $this->commandBus->run($command);

        // when
        $employeeDetails = $this->employeeApi->findEmployeesDetailsByDepartmentId($departmentId);

        // then
        $this->assertCount(2, $employeeDetails);
    }
}
