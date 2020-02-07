<?php

namespace App\Repository\Exception;

use Exception;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
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
