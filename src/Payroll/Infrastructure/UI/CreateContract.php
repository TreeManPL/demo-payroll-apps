<?php

declare(strict_types=1);

namespace App\Payroll\Infrastructure\UI;

use App\Payroll\Application\Command\Contract\CreateContractCommand;
use App\Shared\Application\Command\CommandBusInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contract', methods: ['POST'])]
class CreateContract
{
    public function __construct(private readonly CommandBusInterface $commandBus)
    {
    }

    public function __invoke(Request $request): Response
    {
        $data = $request->toArray();
        $createCommand = new CreateContractCommand(
            $data['userId'],
            (int)($data['salary'] * 100),
            new \DateTime($data['workStartAt']),
        );

        try {
            $this->commandBus->run($createCommand);
        } catch (\Throwable) {
            return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return new Response(status: Response::HTTP_CREATED);
    }
}
