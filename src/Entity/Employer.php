<?php

namespace App\Entity;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class Employer extends EmployerWorkingTime
{
    public int $employerId;
    public string $employerName;
}
