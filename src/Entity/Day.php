<?php

namespace App\Entity;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class Day
{
    public int $number;
    public string $mode;
    public string $date;
    public string $begin;
    public string $end;
    public int $delta = 0;
}
