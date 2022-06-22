<?php

declare(strict_types=1);

namespace App\Tests\Application\Payroll\Infrastructure\UI;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UpdateContractTest extends WebTestCase
{
    /**
     * @test
     */
    public function updateRequestSuccessfully(): void
    {
        $client = self::createClient();
        // given
        $userId = '037b0fcb-d075-4651-aa50-4ab5fbf976f5';
        $salary = 2000;
        $updatedSalary = 3000;

        $client->request(
            method: 'POST',
            uri: '/contract',
            content: \sprintf('{"userId": "%s","salary": %d,"workStartAt": "2022-06-21"}', $userId, $salary)
        );

        // when
        $client->request(
            method: 'PATCH',
            uri: \sprintf('/contract/%s', $userId),
            content: \sprintf('{"salary": %d}', $updatedSalary)
        );

        // then
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
