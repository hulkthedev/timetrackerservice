<?php

namespace App\Tests\Usecase\AddMultiEntities;

use App\Usecase\AddMultiEntities\AddMultiEntitiesInteractor;
use App\Usecase\AddMultiEntities\AddMultiEntitiesRequest;
use App\Usecase\BaseResponse;

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

    }
}
