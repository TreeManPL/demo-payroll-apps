<?php

declare(strict_types=1);

namespace App\Employee\Infrastructure\UI;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/users/{id}', methods: ['PATCH'])]
class AssignUserDepartmentController
{
    public function __invoke(): Response
    {
        return new Response(status: Response::HTTP_OK);
    }
}
