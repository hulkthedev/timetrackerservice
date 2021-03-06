<?php

namespace App\Tests\Usecase\GetAllEntities;

use App\Entity\Day;
use App\Entity\Week;
use App\Repository\Mapper\MariaDbMapper;
use App\Repository\MariaDbConfigRepositoryStub;
use App\Repository\MariaDbTrackingRepository;
use App\Service\CalculationService;
use App\Tests\Cache\ApcuCacheItemPoolStub;
use App\Tests\Repository\MariaDbFetcher;
use App\Tests\Repository\MariaDbTrackingRepositoryDatabaseExceptionStub;
use App\Tests\Repository\MariaDbTrackingRepositoryExceptionStub;
use App\Tests\Repository\PdoStub;
use App\Usecase\GetAllEntities\GetAllEntitiesInteractor;
use App\Usecase\ResultCodes;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class GetAllEntitiesInteractorTest extends TestCase
{
    public function test_Execute_ExpectDatabaseExceptionHandling(): void
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

    public function test_Execute_ExpectExceptionHandling(): void
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

    public function test_Execute_ExpectNoError(): void
    {
        $pdo = new PdoStub();
        $pdo->setFetchAllReturnValue(MariaDbFetcher::get());

        $cache = new ApcuCacheItemPoolStub();
        $repo = new MariaDbTrackingRepository(new MariaDbMapper(), $cache);
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
        TestCase::assertCount(1, $cache->getAll());
    }
}
