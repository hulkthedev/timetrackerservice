<?php

namespace App\Tests\Usecase\UpdateEntity;

use App\Repository\Mapper\MariaDbMapper;
use App\Repository\MariaDbConfigRepositoryStub;
use App\Repository\MariaDbTrackingRepository;
use App\Service\CalculationService;
use App\Tests\Cache\ApcuCacheItemPoolStub;
use App\Tests\Repository\MariaDbTrackingRepositoryDatabaseExceptionStub;
use App\Tests\Repository\MariaDbTrackingRepositoryExceptionStub;
use App\Tests\Repository\MariaDbTrackingRepositoryPDOExceptionStub;
use App\Tests\Repository\PdoStub;
use App\Usecase\ResultCodes;
use App\Usecase\UpdateEntity\UpdateEntityInteractor;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class UpdateEntityInteractorTest extends TestCase
{
    public function test_execute_expectDatabaseExceptionHandling(): void
    {
        $interactor = new UpdateEntityInteractor(
            new MariaDbTrackingRepositoryDatabaseExceptionStub(),
            new MariaDbConfigRepositoryStub(),
            new CalculationService()
        );

        $response = $interactor->execute(new UpdateEntityRequestStub());

        TestCase::assertEquals(ResultCodes::ENTITY_CAN_NOT_BE_UPDATED, $response->presentResponse()['code']);
        TestCase::assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getHttpStatus());
        TestCase::assertEmpty($response->presentResponse()['entities']);
    }

    public function test_execute_expectPDOExceptionHandling(): void
    {
        $interactor = new UpdateEntityInteractor(
            new MariaDbTrackingRepositoryPDOExceptionStub(),
            new MariaDbConfigRepositoryStub(),
            new CalculationService()
        );

        $response = $interactor->execute(new UpdateEntityRequestStub());

        TestCase::assertEquals(ResultCodes::PDO_EXCEPTION, $response->presentResponse()['code']);
        TestCase::assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getHttpStatus());
        TestCase::assertEmpty($response->presentResponse()['entities']);
    }

    public function test_execute_expectExceptionHandling(): void
    {
        $interactor = new UpdateEntityInteractor(
            new MariaDbTrackingRepositoryExceptionStub(),
            new MariaDbConfigRepositoryStub(),
            new CalculationService()
        );

        $response = $interactor->execute(new UpdateEntityRequestStub());

        TestCase::assertEquals(ResultCodes::UNKNOWN_ERROR, $response->presentResponse()['code']);
        TestCase::assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getHttpStatus());
        TestCase::assertEmpty($response->presentResponse()['entities']);
    }

    public function test_execute_expectNoError(): void
    {
        $pdo = new PdoStub();
        $pdo->setExecuteReturnValue(true);

        $cache = new ApcuCacheItemPoolStub();
        $repo = new MariaDbTrackingRepository(new MariaDbMapper(), $cache);
        $repo->setPdoDriver($pdo);

        $interactor = new UpdateEntityInteractor($repo, new MariaDbConfigRepositoryStub(), new CalculationService());
        $response = $interactor->execute(new UpdateEntityRequestStub());

        TestCase::assertEquals(ResultCodes::SUCCESS, $response->presentResponse()['code']);
        TestCase::assertEquals(Response::HTTP_OK, $response->getHttpStatus());
        TestCase::assertEmpty($response->presentResponse()['entities']);
        TestCase::assertEmpty($cache->getAll());
    }
}
