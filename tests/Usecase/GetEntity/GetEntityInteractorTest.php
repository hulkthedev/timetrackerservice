<?php

namespace App\Tests\Usecase\GetEntity;

use App\Entity\Day;
use App\Repository\Mapper\MariaDbMapper;
use App\Repository\MariaDbConfigRepositoryStub;
use App\Repository\MariaDbTrackingRepository;
use App\Service\CalculationService;
use App\Tests\Repository\MariaDbFetcher;
use App\Tests\Repository\MariaDbTrackingRepositoryDatabaseExceptionStub;
use App\Tests\Repository\MariaDbTrackingRepositoryExceptionStub;
use App\Tests\Repository\MariaDbTrackingRepositoryPDOExceptionStub;
use App\Tests\Repository\PdoStub;
use App\Tests\Service\ApcuCacheServiceStub;
use App\Usecase\GetEntity\GetEntityInteractor;
use App\Usecase\Modes;
use App\Usecase\ResultCodes;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class GetEntityInteractorTest extends TestCase
{
    public function test_execute_expectDatabaseExceptionHandling(): void
    {
        $interactor = new GetEntityInteractor(
            new MariaDbTrackingRepositoryDatabaseExceptionStub(),
            new MariaDbConfigRepositoryStub(),
            new CalculationService()
        );

        $response = $interactor->execute(new GetEntityRequestStub());

        TestCase::assertEquals(ResultCodes::ENTITY_NOT_FOUND, $response->presentResponse()['code']);
        TestCase::assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getHttpStatus());
        TestCase::assertEmpty($response->presentResponse()['entities']);
    }

    public function test_execute_expectPDOExceptionHandling(): void
    {
        $interactor = new GetEntityInteractor(
            new MariaDbTrackingRepositoryPDOExceptionStub(),
            new MariaDbConfigRepositoryStub(),
            new CalculationService()
        );

        $response = $interactor->execute(new GetEntityRequestStub());

        TestCase::assertEquals(ResultCodes::PDO_EXCEPTION, $response->presentResponse()['code']);
        TestCase::assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getHttpStatus());
        TestCase::assertEmpty($response->presentResponse()['entities']);
    }

    public function test_execute_expectExceptionHandling(): void
    {
        $interactor = new GetEntityInteractor(
            new MariaDbTrackingRepositoryExceptionStub(),
            new MariaDbConfigRepositoryStub(),
            new CalculationService()
        );

        $response = $interactor->execute(new GetEntityRequestStub());

        TestCase::assertEquals(ResultCodes::UNKNOWN_ERROR, $response->presentResponse()['code']);
        TestCase::assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getHttpStatus());
        TestCase::assertEmpty($response->presentResponse()['entities']);
    }

    public function test_execute_expectNoError(): void
    {
        $pdo = new PdoStub();
        $pdo->setFetchAllReturnValue(MariaDbFetcher::get());

        $repo = new MariaDbTrackingRepository(new MariaDbMapper(), new ApcuCacheServiceStub());
        $repo->setPdoDriver($pdo);

        $interactor = new GetEntityInteractor($repo, new MariaDbConfigRepositoryStub(), new CalculationService());
        $response = $interactor->execute(new GetEntityRequestStub());

        TestCase::assertEquals(ResultCodes::SUCCESS,  $response->presentResponse()['code']);
        TestCase::assertEquals(Response::HTTP_OK, $response->getHttpStatus());

        /** @var Day $day */
        $day = reset($response->presentResponse()['entities']);
        TestCase::assertInstanceOf(Day::class, $day);
        TestCase::assertEquals('2020-01-06', $day->date);
        TestCase::assertEquals(Modes::MODE_WORKING, $day->mode);
        TestCase::assertEquals('09:08', $day->begin);
        TestCase::assertEquals('16:52', $day->end);
        TestCase::assertEquals(30, $day->delta);
        TestCase::assertEquals(1, $day->employerId);
        TestCase::assertEquals('Google', $day->employerName);
        TestCase::assertEquals(1, $day->workingTimeId);
        TestCase::assertEquals('Fulltime', $day->workingTimeDescription);
    }
}
