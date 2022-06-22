<?php

declare(strict_types=1);

namespace App\Tests\Integration\Employee\Application\Command\User;

use App\Employee\Application\Command\Deprtment\CreateDepartmentCommand;
use App\Employee\Application\Command\User\CreateUserCommand;
use App\Employee\Application\Exception\DepartmentNotExistsException;
use App\Employee\Application\Exception\UserAlreadyExistsException;
use App\Employee\Domain\Repository\UserRepositoryInterface;
use App\Shared\Application\Command\CommandBusInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CreateUserHandlerTest extends KernelTestCase
{
    private CommandBusInterface $commandBus;
    private UserRepositoryInterface $userRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->commandBus = static::getContainer()->get(CommandBusInterface::class);
        $this->userRepository = static::getContainer()->get(UserRepositoryInterface::class);
    }

    /**
     * @test
     */
    public function userCreatedWithoutDepartmentSuccessfully(): void
    {
        // given
        $id = '59bc24a6-2df8-4a78-bcbb-e067b6c3f8a3';
        $command = new CreateUserCommand(
            $id,
            'First Name',
            'Last Name',
            null
        );

        // when
        $this->commandBus->run($command);
        $user = $this->userRepository->findById($id);

        // then
        $this->assertNotNull($user);
    }

    /**
     * @test
     */
    public function userCreatedWithDepartmentSuccessfully(): void
    {
        // given
        $departmentId = '00ea7798-b419-4bf5-9cc9-c3810bb2cd8c';
        $command = new CreateDepartmentCommand(
            $departmentId,
            'Test Department'
        );
        $this->commandBus->run($command);

        $id = '52f1ca4d-56c3-4bd6-930f-acfafdab06a2';
        $command = new CreateUserCommand(
            $id,
            'First Name',
            'Last Name',
            $departmentId
        );

        // when
        $this->commandBus->run($command);
        $user = $this->userRepository->findById($id);

        // then
        $this->assertNotNull($user);
    }

    /**
     * @test
     */
    public function throwExceptionOnDuplicateUser(): void
    {
        // given
        $id = 'a293287e-d366-4efc-9480-4caf13405afe';
        $command = new CreateUserCommand(
            $id,
            'First Name',
            'Last Name',
            null
        );

        // when
        $this->commandBus->run($command);
        // then
        $this->expectException(UserAlreadyExistsException::class);
        $this->commandBus->run($command);
    }

    /**
     * @test
     */
    public function throwExceptionOnMissingDepartment(): void
    {
        // given
        $id = '42d1b846-692f-458e-8622-63d65bddd044';
        $notExistingDepartmentId = 'a44fa9f6-9565-4ef0-a303-54a171059cb6';

        $command = new CreateUserCommand(
            $id,
            'First Name',
            'Last Name',
            $notExistingDepartmentId
        );

        // then
        $this->expectException(DepartmentNotExistsException::class);
        // when
        $this->commandBus->run($command);
    }
}
