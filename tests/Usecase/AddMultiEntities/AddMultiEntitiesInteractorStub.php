<?php

namespace App\Tests\Usecase\AddMultiEntities;

use App\Usecase\AddMultiEntities\AddMultiEntitiesInteractor;
use App\Usecase\AddMultiEntities\AddMultiEntitiesRequest;
use App\Usecase\AddMultiEntities\AddMultiEntitiesResponse;
use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class AddMultiEntitiesInteractorStub extends AddMultiEntitiesInteractor
{
    public function __construct()
    {
    }

    /**
     * @inheritDoc
     */
    public function execute(AddMultiEntitiesRequest $request): BaseResponse
    {
        $response = new AddMultiEntitiesResponse(ResultCodes::SUCCESS);
        $response->setHttpStatus(Response::HTTP_CREATED);

        return $response;
    }
}
