<?php

declare(strict_types=1);

namespace App\Tests\Application\Payroll\Infrastructure\UI;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UpdateDepartmentBonusTest extends WebTestCase
{
    /**
     * @test
     */
    public function updateRequestSuccessfully(): void
    {
        $client = self::createClient();
        // given
        $departmentId = 'a05612dc-6a37-432c-8527-c730effd396d';

        $client->request(
            method: 'POST',
            uri: '/bonuses/department',
            content: \sprintf('{"departmentId": "%s", "type": "percent", "value": 50}', $departmentId)
        );

        // when
        $client->request(
            method: 'PATCH',
            uri: \sprintf('/bonuses/department/%s', $departmentId),
            content: \sprintf('{"type": "percent", "value": %d}', 15)
        );

        // then
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
