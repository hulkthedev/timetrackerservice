<?php

namespace App\Usecase\ChangeEntity;

use App\Usecase\BaseInteractor;
use App\Usecase\EntityRequestInterface;
use App\Usecase\ResultCodes;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class ChangeEntityInteractor extends BaseInteractor
{
    /**
     * @param EntityRequestInterface $request
     * @return array
     */
    public function execute(EntityRequestInterface $request): array
    {
        return [
            'code' => ResultCodes::CODE_SUCCESS,
            'entities' => []
        ];
    }
}
