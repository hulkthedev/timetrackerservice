<?php

namespace App\Usecase;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class ResultCodes
{
    /* exceptions */
    public const ENTITY_NOT_FOUND_EXCEPTION = -11;
    public const PDO_EXCEPTION = -10;

    /* validation */
    public const INVALID_JSON_CONTENT = -3;
    public const INVALID_MEDIA_TYPE = -2;
    public const INVALID_SYNTAX = -1;

    public const UNKNOWN_ERROR = -99;
    public const SUCCESS = 1;
}
