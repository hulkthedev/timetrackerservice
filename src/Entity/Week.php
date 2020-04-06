<?php

namespace App\Entity;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class Week
{
    public int $no;
    public int $delta;
    public string $deltaFormatted;
    public array $days;
}
