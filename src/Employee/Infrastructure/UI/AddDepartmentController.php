<?php

declare(strict_types=1);

namespace App\Employee\Infrastructure\UI;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/departments', methods: ['POST'])]
class AddDepartmentController
{
    public function __invoke(): Response
    {
        return new Response(status: Response::HTTP_CREATED);
    }
}
