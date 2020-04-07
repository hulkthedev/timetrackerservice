<?php

namespace App\Tests\Usecase\GetEntity;

use App\Repository\Exception\DatabaseException;
use App\Repository\Mapper\MariaDbMapper;
use App\Tests\Repository\MariaDbFetcher;
use App\Usecase\BaseResponse;
use App\Usecase\GetEntity\GetEntityInteractor;
use App\Usecase\GetEntity\GetEntityRequest;
use App\Usecase\GetEntity\GetEntityResponse;
use App\Usecase\ResultCodes;
use Exception;
use Throwable;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class GetEntityInteractorStub extends GetEntityInteractor
{
    public function __construct()
    {
    }

    public function execute(GetEntityRequest $request): BaseResponse
    {
        try {
            return new GetEntityResponse(ResultCodes::SUCCESS, $this->getEntity());
        } catch (DatabaseException $exception) {
            return $this->createUnsuccessfullyResponse($exception->getCode());
        } catch (Throwable $throwable) {
            return $this->createUnsuccessfullyResponse(ResultCodes::UNKNOWN_ERROR);
        }
    }

    /**
     * @return array
     * @throws Exception
     */
    private function getEntity()
    {
        $entity = MariaDbFetcher::get();

        $mapper = new MariaDbMapper();
        return [$mapper->mapEntityToDay(reset($entity))];
    }
}
