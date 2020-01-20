<?php

namespace App\Usecase\GetEntity;

use App\Usecase\ResultCodes;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class GetEntityInteractor
{
    public function __construct()
    {

    }

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
