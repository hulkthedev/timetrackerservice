<?php

namespace App\Entity;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class Week
{
    /** @var int */
    public $number;

    /** @var int */
    public $delta;

    /** @var Day[] */
    public $days;
}
