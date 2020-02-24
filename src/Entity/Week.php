<?php

namespace App\Entity;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class Week
{
    public int $no;
    public int $delta;
    public string $deltaFormatted;
    public array $days;
}
