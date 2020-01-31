<?php

namespace App\Repository\Exception;

use App\Usecase\ResultCodes;
use Exception;
use Throwable;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class EntityNotFoundException extends Exception
{
    /**
     * @inheritDoc
     */
    public function __construct($message = '', $code = ResultCodes::ENTITY_NOT_FOUND_EXCEPTION, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
