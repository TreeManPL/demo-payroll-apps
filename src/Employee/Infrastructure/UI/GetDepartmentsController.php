<?php

declare(strict_types=1);

namespace App\Employee\Infrastructure\UI;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/departments', methods: ['GET'])]
class GetDepartmentsController
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(
            [
                ['id' => 'c5ee6c5c-90dd-48c2-87ca-4b4f00480710', 'name' => 'HR'],
                ['id' => 'bed4d948-e287-4ad5-a47b-54f83d25b884', 'name' => 'Development'],
            ]
        );
    }
}
