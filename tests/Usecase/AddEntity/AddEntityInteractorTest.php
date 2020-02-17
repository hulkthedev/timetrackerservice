<?php

namespace App\Tests\Usecase\AddEntity;

use App\Repository\Mapper\MariaDbMapper;
use App\Repository\MariaDbConfigRepositoryStub;
use App\Repository\MariaDbTrackingRepository;
use App\Service\CalculationService;
use App\Tests\Repository\MariaDbTrackingRepositoryDatabaseExceptionStub;
use App\Tests\Repository\MariaDbTrackingRepositoryExceptionStub;
use App\Tests\Repository\MariaDbTrackingRepositoryPDOExceptionStub;
use App\Tests\Repository\PdoStub;
use App\Usecase\AddEntity\AddEntityInteractor;
use App\Usecase\ResultCodes;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class AddEntityInteractorTest extends TestCase
{
    public function test_execute_expectDatabaseExceptionHandling(): void
    {
        $interactor = new AddEntityInteractor(
            new MariaDbTrackingRepositoryDatabaseExceptionStub(),
            new MariaDbConfigRepositoryStub(),
            new CalculationService()
        );

        $response = $interactor->execute(new AddEntityRequestStub());

        TestCase::assertEquals(ResultCodes::ENTITY_CAN_NOT_BE_SAVED, $response->presentResponse()['code']);
        TestCase::assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getHttpStatus());
        TestCase::assertEmpty($response->presentResponse()['entities']);
    }

    public function test_execute_expectPDOExceptionHandling(): void
    {
        $interactor = new AddEntityInteractor(
            new MariaDbTrackingRepositoryPDOExceptionStub(),
            new MariaDbConfigRepositoryStub(),
            new CalculationService()
        );

        $response = $interactor->execute(new AddEntityRequestStub());

        TestCase::assertEquals(ResultCodes::PDO_EXCEPTION, $response->presentResponse()['code']);
        TestCase::assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getHttpStatus());
        TestCase::assertEmpty($response->presentResponse()['entities']);
    }

    public function test_execute_expectExceptionHandling(): void
    {
        $interactor = new AddEntityInteractor(
            new MariaDbTrackingRepositoryExceptionStub(),
            new MariaDbConfigRepositoryStub(),
            new CalculationService()
        );

        $response = $interactor->execute(new AddEntityRequestStub());

        TestCase::assertEquals(ResultCodes::UNKNOWN_ERROR, $response->presentResponse()['code']);
        TestCase::assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getHttpStatus());
        TestCase::assertEmpty($response->presentResponse()['entities']);
    }

    public function test_execute_expectNoError(): void
    {
        $pdo = new PdoStub();
        $pdo->setExecuteReturnValue(true);

        $repo = new MariaDbTrackingRepository(new MariaDbMapper());
        $repo->setPdoDriver($pdo);

        $interactor = new AddEntityInteractor($repo, new MariaDbConfigRepositoryStub(), new CalculationService());
        $response = $interactor->execute(new AddEntityRequestStub());

        TestCase::assertEquals(ResultCodes::SUCCESS, $response->presentResponse()['code']);
        TestCase::assertEquals(Response::HTTP_CREATED, $response->getHttpStatus());
        TestCase::assertEmpty($response->presentResponse()['entities']);
    }
}
