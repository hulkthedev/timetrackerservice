<?php

namespace App\Entity;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class Day extends Employer
{
    public int $weekday;
    public string $date;
    public string $begin;
    public string $end;
    public string $mode;
    public int $delta;
    public int $break;
}
