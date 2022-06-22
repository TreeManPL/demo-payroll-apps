<?php

declare(strict_types=1);

namespace App\Employee\Infrastructure\UI;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/users/{id}', methods: ['PATCH'])]
class GetUserController
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(
            [
                'firstName' => 'Mario',
                'lastName' => 'Kowalski',
                'departmentId' => '56fd426c-388d-45d8-839b-52a632b2a3af'
            ]
        );
    }
}
