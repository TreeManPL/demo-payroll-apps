<?php

declare(strict_types=1);

namespace App\Tests\Application\Payroll\Infrastructure\UI;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CreateContractTest extends WebTestCase
{
    /**
     * @test
     */
    public function contractRequestSuccessfully(): void
    {
        // when
        $client = self::createClient();
        $client->request(
            method: 'POST',
            uri: '/contract',
            content: '{"userId": "3fa85f64-5717-4562-b3fc-2c963f66afa6","salary": 1000,"workStartAt": "2022-06-21"}'
        );

        // then
        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);
    }
}
