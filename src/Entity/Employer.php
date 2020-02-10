<?php

namespace App\Entity;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class Employer extends EmployerWorkingTime
{
    public int $employerId;
    public string $employerName;
}
