<?php

namespace App\Usecase\AddEntity;

use App\Usecase\BaseInteractor;
use App\Usecase\ResultCodes;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class AddEntityInteractor extends BaseInteractor
{
    /**
     * @return array
     */
    public function execute(): array
    {
        return [
            'code' => ResultCodes::CODE_SUCCESS,
            'entries' => []
        ];
    }
}
