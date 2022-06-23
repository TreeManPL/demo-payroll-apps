<?php

declare(strict_types=1);

namespace App\Tests\Application\Payroll\Infrastructure\UI;

use App\Payroll\Domain\Entity\PayrollProjection;
use App\Payroll\Domain\Repository\PayrollProjectionRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class GetPayrollsTest extends WebTestCase
{
    private const RESPONSE_ROOT_DIR = './tests/Application/Payroll/Infrastructure/UI/Resource/';

    public static function setUpBeforeClass(): void
    {
        $payrollProjectionRepository = static::getContainer()->get(PayrollProjectionRepositoryInterface::class);
        $userOne = new PayrollProjection('9fb9cf70-53cb-4c18-bd92-5712f7deff43', 'Adam', 'Ender', 'ABC', 10000, 150, 'percent', 10150);
        $payrollProjectionRepository->save($userOne);
        $userTwo = new PayrollProjection('19adaf25-98fb-464d-adf1-418357f8cb53', 'Mike', 'Andrus', 'ABC', 25000, 3000, 'fixed', 28000);
        $payrollProjectionRepository->save($userTwo);
        $userThree = new PayrollProjection('ae1f9ea0-797a-4fe2-9da2-d0a5009b8e95', 'Zack', 'Wilder', 'ZAC', 50000, 2500, 'percent', 52500);
        $payrollProjectionRepository->save($userThree);

        parent::setUpBeforeClass();
    }

    /**
     * @test
     */
    public function sortSuccessfullyResponse(): void
    {
        $client = self::createClient();
        // when
        $client->request(
            method: 'GET',
            uri: '/payrolls?sort=bonusSalary',
        );

        // then
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertJsonStringEqualsJsonFile(self::RESPONSE_ROOT_DIR.'sort_successfully_response.json', $client->getResponse()->getContent());
    }

    /**
     * @test
     */
    public function orderSuccessfullyResponse(): void
    {
        $client = self::createClient();
        // when
        $client->request(
            method: 'GET',
            uri: '/payrolls?sort=firstName&dir=desc',
        );

        // then
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertJsonStringEqualsJsonFile(self::RESPONSE_ROOT_DIR.'order_successfully_response.json', $client->getResponse()->getContent());
    }

    /**
     * @test
     */
    public function filterSuccessfullyResponse(): void
    {
        $client = self::createClient();
        // when
        $client->request(
            method: 'GET',
            uri: '/payrolls?filter[lastName]=Andrus',
        );

        // then
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertJsonStringEqualsJsonFile(self::RESPONSE_ROOT_DIR.'filter_successfully_response.json', $client->getResponse()->getContent());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->tearDown();
    }
}
