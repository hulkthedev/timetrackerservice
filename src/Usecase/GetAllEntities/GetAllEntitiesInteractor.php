<?php

namespace App\Usecase\GetAllEntities;

use App\Usecase\BaseInteractor;
use App\Usecase\ResultCodes;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class GetAllEntitiesInteractor extends BaseInteractor
{
    /**
     * @return array
     */
    public function execute(): array
    {
        return [
            'code' => ResultCodes::CODE_SUCCESS,
            'message' => null
        ];
    }
}
