<?php

namespace App\Usecase;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class ResultCodes
{
    /* exceptions */
    public const CODE_UNKNOWN_ERROR = -11;
    public const CODE_PDO_EXCEPTION = -10;

    /* validation */
    public const CODE_INVALID_JSON_CONTENT = -3;
    public const CODE_INVALID_MEDIA_TYPE = -2;
    public const CODE_INVALID_SYNTAX = -1;

    public const CODE_SUCCESS = 1;
}
