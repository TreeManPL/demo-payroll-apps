<?php

declare(strict_types=1);

namespace App\Tests\Application\Payroll\Infrastructure\UI;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CreateDepartmentBonusTest extends WebTestCase
{
    /**
     * @test
     */
    public function contract_request_successfully(): void
    {
        // when
        $client = self::createClient();
        $client->request(
            method: 'POST',
            uri: '/bonuses/department',
            content: '{"departmentId": "3fa85f64-5717-4562-b3fc-2c963f66afa6", "type": "percent", "value": 50}'
        );

        // then
        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);
    }
}
