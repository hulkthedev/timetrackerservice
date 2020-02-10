<?php

namespace App\Entity;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class Day extends Employer
{
    public int $weekDay;
    public string $mode;
    public string $date;
    public string $begin;
    public string $end;
    public int $delta;
    public int $break;
}
