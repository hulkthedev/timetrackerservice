<?php

namespace App\Tests\Usecase\AddMultiEntities;

use App\Repository\Mapper\MariaDbMapper;
use App\Repository\MariaDbTrackingRepository;
use App\Tests\Repository\MariaDbTrackingRepositoryDatabaseExceptionStub;
use App\Tests\Repository\MariaDbTrackingRepositoryExceptionStub;
use App\Tests\Repository\MariaDbTrackingRepositoryPDOExceptionStub;
use App\Tests\Repository\PdoStub;
use App\Usecase\AddMultiEntities\AddMultiEntitiesInteractor;
use App\Usecase\ResultCodes;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class AddMultiEntitiesInteractorTest extends TestCase
{
    public function test_execute_expectDatabaseExceptionHandling(): void
    {
        $interactor = new AddMultiEntitiesInteractor(new MariaDbTrackingRepositoryDatabaseExceptionStub());
        $response = $interactor->execute(new AddMultiEntityRequestStub());

        TestCase::assertEquals(ResultCodes::ENTITY_CAN_NOT_BE_SAVED, $response->presentResponse()['code']);
        TestCase::assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getHttpStatus());
        TestCase::assertEmpty($response->presentResponse()['entities']);
    }

    public function test_execute_expectPDOExceptionHandling(): void
    {
        $interactor = new AddMultiEntitiesInteractor(new MariaDbTrackingRepositoryPDOExceptionStub());
        $response = $interactor->execute(new AddMultiEntityRequestStub());

        TestCase::assertEquals(ResultCodes::PDO_EXCEPTION, $response->presentResponse()['code']);
        TestCase::assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getHttpStatus());
        TestCase::assertEmpty($response->presentResponse()['entities']);
    }

    public function test_execute_expectExceptionHandling(): void
    {
        $interactor = new AddMultiEntitiesInteractor(new MariaDbTrackingRepositoryExceptionStub());
        $response = $interactor->execute(new AddMultiEntityRequestStub());

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

        $interactor = new AddMultiEntitiesInteractor($repo);
        $response = $interactor->execute(new AddMultiEntityRequestStub());

        TestCase::assertEquals(ResultCodes::SUCCESS, $response->presentResponse()['code']);
        TestCase::assertEquals(Response::HTTP_CREATED, $response->getHttpStatus());
        TestCase::assertEmpty($response->presentResponse()['entities']);
    }
}