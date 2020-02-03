<?php

namespace App\Entity;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class Day
{
    public int $id;
    public string $mode;
    public string $date;
    public int $begin;
    public int $end;
    public int $delta;
}
