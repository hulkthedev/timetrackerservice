<?php

namespace App\Usecase\GetAllEntities;

use App\Usecase\BaseInteractor;
use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class GetAllEntitiesInteractor extends BaseInteractor
{
    /**
     * @return BaseResponse
     */
    public function execute(): BaseResponse
    {
        try {

        } catch (\Exception $exception) {

        }

        return new GetAllEntitiesResponse(ResultCodes::CODE_SUCCESS);
    }
}
