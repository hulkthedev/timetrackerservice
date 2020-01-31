<?php

namespace App\Entity;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class Day
{
    public int $id;
    public string $date;
    public string $begin;
    public string $end;
    public string $mode;
    public int $delta;
}
