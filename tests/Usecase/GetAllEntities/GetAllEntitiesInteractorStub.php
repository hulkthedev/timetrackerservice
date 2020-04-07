<?php

namespace App\Tests\Usecase\GetAllEntities;

use App\Usecase\BaseResponse;
use App\Usecase\GetAllEntities\GetAllEntitiesInteractor;
use App\Usecase\GetAllEntities\GetAllEntitiesRequest;
use App\Usecase\GetAllEntities\GetAllEntitiesResponse;
use App\Usecase\ResultCodes;
use Symfony\Component\HttpFoundation\Response;

class GetAllEntitiesInteractorStub extends GetAllEntitiesInteractor
{
    public function __construct()
    {
    }

    public function execute(GetAllEntitiesRequest $request): BaseResponse
    {
        return new GetAllEntitiesResponse(ResultCodes::SUCCESS);
    }
}
