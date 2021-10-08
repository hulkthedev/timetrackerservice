<?php

namespace App\Tests\Entity;

use App\Entity\Config;
use Exception;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class ConfigExceptionStub extends Config
{
    /**
     * @param string $name
     * @throws Exception
     */
    public function __get($name)
    {
        throw new Exception('UnitTest');
    }
}
