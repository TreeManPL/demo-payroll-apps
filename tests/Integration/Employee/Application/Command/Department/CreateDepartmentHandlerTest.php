<?php

declare(strict_types=1);

namespace App\Tests\Integration\Employee\Application\Command\Department;

use App\Employee\Application\Command\Deprtment\CreateDepartmentCommand;
use App\Employee\Application\Exception\DepartmentAlreadyExistsException;
use App\Employee\Domain\Repository\DepartmentRepositoryInterface;
use App\Shared\Application\Command\CommandBusInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CreateDepartmentHandlerTest extends KernelTestCase
{
    private CommandBusInterface $commandBus;
    private DepartmentRepositoryInterface $departmentRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->commandBus = static::getContainer()->get(CommandBusInterface::class);
        $this->departmentRepository = static::getContainer()->get(DepartmentRepositoryInterface::class);
    }

    /**
     * @test
     */
    public function departmentCreatedSuccessfully(): void
    {
        // given
        $id = '960a00d8-4ca6-4b71-9ff7-82cd5d17f3fd';
        $command = new CreateDepartmentCommand(
            $id,
            'Test Department'
        );

        // when
        $this->commandBus->run($command);
        $department = $this->departmentRepository->findById($id);

        // then
        $this->assertNotNull($department);
    }

    /**
     * @test
     */
    public function throwExceptionOnDuplicateDepartment(): void
    {
        // given
        $id = '369f1b00-c820-4dac-9fcb-ee9e64666d3f';
        $command = new CreateDepartmentCommand(
            $id,
            'Test Department Two'
        );

        // when
        $this->commandBus->run($command);
        // then
        $this->expectException(DepartmentAlreadyExistsException::class);
        $this->commandBus->run($command);
    }
}
