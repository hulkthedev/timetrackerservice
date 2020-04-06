<?php

namespace App\Repository\Exception;

use Exception;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 * @codeCoverageIgnore
 */
class DatabaseException extends Exception
{
    /**
     * @inheritDoc
     */
    public function __construct(int $code)
    {
        parent::__construct('', $code, null);
    }
}
