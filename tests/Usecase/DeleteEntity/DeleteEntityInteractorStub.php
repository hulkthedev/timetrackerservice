<?php

namespace App\Tests\Usecase\DeleteEntity;

use App\Usecase\BaseResponse;
use App\Usecase\DeleteEntity\DeleteEntityInteractor;
use App\Usecase\DeleteEntity\DeleteEntityRequest;
use App\Usecase\DeleteEntity\DeleteEntityResponse;
use App\Usecase\ResultCodes;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class DeleteEntityInteractorStub extends DeleteEntityInteractor
{
    public function __construct()
    {
    }

    /**
     * @inheritDoc
     */
    public function execute(DeleteEntityRequest $request): BaseResponse
    {
        return new DeleteEntityResponse(ResultCodes::SUCCESS);
    }
}
