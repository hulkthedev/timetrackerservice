<?php

namespace App\Usecase;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class ResultCodes
{
    /* exceptions */
    public const ENTITY_CAN_NOT_BE_UPDATED = -15;
    public const ENTITY_CAN_NOT_BE_DELETED = -14;
    public const ENTITY_CAN_NOT_BE_SAVED = -13;
    public const ENTITY_NOT_FOUND = -12;
    public const DATABASE_IS_EMPTY = -11;
    public const PDO_EXCEPTION = -10;

    /* validation */
    public const INVALID_JSON_CONTENT = -3;
    public const INVALID_MEDIA_TYPE = -2;
    public const INVALID_SYNTAX = -1;

    public const UNKNOWN_ERROR = -99;
    public const SUCCESS = 1;
}
