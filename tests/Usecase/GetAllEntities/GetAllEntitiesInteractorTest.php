<?php

namespace App\Tests\Usecase\GetAllEntities;

use App\Entity\Day;
use App\Entity\Week;
use App\Repository\Mapper\MariaDbMapper;
use App\Repository\MariaDbConfigRepositoryStub;
use App\Repository\MariaDbTrackingRepository;
use App\Service\CalculationService;
use App\Tests\Repository\MariaDbFetcher;
use App\Tests\Repository\MariaDbTrackingRepositoryDatabaseExceptionStub;
use App\Tests\Repository\MariaDbTrackingRepositoryExceptionStub;
use App\Tests\Repository\MariaDbTrackingRepositoryPDOExceptionStub;
use App\Tests\Repository\PdoStub;
use App\Usecase\GetAllEntities\GetAllEntitiesInteractor;
use App\Usecase\ResultCodes;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class GetAllEntitiesInteractorTest extends TestCase
{
    public function test_execute_expectDatabaseExceptionHandling(): void
    {
        $interactor = new GetAllEntitiesInteractor(
            new MariaDbTrackingRepositoryDatabaseExceptionStub(),
            new MariaDbConfigRepositoryStub(),
            new CalculationService()
        );

        $response = $interactor->execute(new GetAllEntitiesRequestStub());

        TestCase::assertEquals(ResultCodes::DATABASE_IS_EMPTY, $response->presentResponse()['code']);
        TestCase::assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getHttpStatus());
        TestCase::assertEmpty($response->presentResponse()['entities']);
    }

    public function test_execute_expectPDOExceptionHandling(): void
    {
        $interactor = new GetAllEntitiesInteractor(
            new MariaDbTrackingRepositoryPDOExceptionStub(),
            new MariaDbConfigRepositoryStub(),
            new CalculationService()
        );

        $response = $interactor->execute(new GetAllEntitiesRequestStub());

        TestCase::assertEquals(ResultCodes::PDO_EXCEPTION, $response->presentResponse()['code']);
        TestCase::assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getHttpStatus());
        TestCase::assertEmpty($response->presentResponse()['entities']);
    }

    public function test_execute_expectExceptionHandling(): void
    {
        $interactor = new GetAllEntitiesInteractor(
            new MariaDbTrackingRepositoryExceptionStub(),
            new MariaDbConfigRepositoryStub(),
            new CalculationService()
        );

        $response = $interactor->execute(new GetAllEntitiesRequestStub());

        TestCase::assertEquals(ResultCodes::UNKNOWN_ERROR, $response->presentResponse()['code']);
        TestCase::assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getHttpStatus());
        TestCase::assertEmpty($response->presentResponse()['entities']);
    }

    public function test_execute_expectNoError(): void
    {
        $pdo = new PdoStub();
        $pdo->setFetchAllReturnValue(MariaDbFetcher::get());

        $repo = new MariaDbTrackingRepository(new MariaDbMapper());
        $repo->setPdoDriver($pdo);

        $interactor = new GetAllEntitiesInteractor($repo, new MariaDbConfigRepositoryStub(), new CalculationService());
        $response = $interactor->execute(new GetAllEntitiesRequestStub());

        TestCase::assertEquals(ResultCodes::SUCCESS,  $response->presentResponse()['code']);
        TestCase::assertEquals(Response::HTTP_OK, $response->getHttpStatus());

        /** @var Week $week */
        $week = reset($response->presentResponse()['entities']);
        TestCase::assertInstanceOf(Week::class, $week);
        TestCase::assertInstanceOf(Day::class, $week->days[0]);
        TestCase::assertEquals(1, count($week->days));
        TestCase::assertEquals(2, $week->no);
    }
}
