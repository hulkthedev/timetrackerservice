<?php

namespace App\Tests\Usecase\GetAllEntities;

use App\Repository\Exception\DatabaseException;
use App\Repository\Mapper\MariaDbMapper;
use App\Tests\Repository\MariaDbFetcher;
use App\Usecase\BaseResponse;
use App\Usecase\GetAllEntities\GetAllEntitiesInteractor;
use App\Usecase\GetAllEntities\GetAllEntitiesRequest;
use App\Usecase\GetAllEntities\GetAllEntitiesResponse;
use App\Usecase\ResultCodes;
use Exception;
use Throwable;

class GetAllEntitiesInteractorStub extends GetAllEntitiesInteractor
{
    public function __construct()
    {
    }

    /**
     * @inheritDoc
     */
    public function execute(GetAllEntitiesRequest $request): BaseResponse
    {
        try {
            return new GetAllEntitiesResponse(ResultCodes::SUCCESS, $this->getList());
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
    private function getList()
    {
        $mapper = new MariaDbMapper();
        return $mapper->mapToList(MariaDbFetcher::getAll());
    }
}
