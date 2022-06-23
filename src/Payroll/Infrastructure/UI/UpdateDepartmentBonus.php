<?php

declare(strict_types=1);

namespace App\Payroll\Infrastructure\UI;

use App\Payroll\Application\Command\DepartmentBonus\UpdateDepartmentBonusCommand;
use App\Shared\Application\Command\CommandBusInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/bonuses/department/{departmentId}', methods: ['PATCH'])]
class UpdateDepartmentBonus
{
    public function __construct(private readonly CommandBusInterface $commandBus)
    {
    }

    public function __invoke(string $departmentId, Request $request): Response
    {
        $data = $request->toArray();
        $createCommand = new UpdateDepartmentBonusCommand(
            $departmentId,
            $data['type'],
            $data['type'] === 'fixed' ? (int)($data['value'] * 100) : $data['value']
        );

        try {
            $this->commandBus->run($createCommand);
        } catch (\Throwable) {
            return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return new Response(status: Response::HTTP_OK);
    }
}
