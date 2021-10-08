<?php

namespace App\Tests\Usecase\UpdateEntity;

use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;
use App\Usecase\UpdateEntity\UpdateEntityInteractor;
use App\Usecase\UpdateEntity\UpdateEntityRequest;
use App\Usecase\UpdateEntity\UpdateEntityResponse;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class UpdateEntityInteractorStub extends UpdateEntityInteractor
{
    public function __construct()
    {
    }

    /**
     * @inheritDoc
     */
    public function execute(UpdateEntityRequest $request): BaseResponse
    {
        return new UpdateEntityResponse(ResultCodes::SUCCESS);
    }
}
