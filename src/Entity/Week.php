<?php

namespace App\Entity;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class Week
{
    public int $number;
    public int $delta;

    /** @var Day[] */
    public array $days;
}
