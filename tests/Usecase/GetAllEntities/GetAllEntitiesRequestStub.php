<?php

namespace App\Tests\Usecase\GetAllEntities;

use App\Usecase\GetAllEntities\GetAllEntitiesRequest;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class GetAllEntitiesRequestStub extends GetAllEntitiesRequest
{
    public function __construct()
    {
        $this->employerId = 1;
    }
}
