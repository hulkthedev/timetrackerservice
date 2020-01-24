<?php

namespace App\Usecase;

use App\Entity\Day;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
abstract class BaseResponse
{
    /** @var int */
    private $code;

    /** @var Day[] */
    private $entities;

    /**
     * @param Day[] $entities
     * @param int $code
     */
    public function __construct(int $code, array $entities = [])
    {
        $this->code = $code;
        $this->entities = $entities;
    }

    /**
     * @return array
     */
    public function presentResponse(): array
    {
        return [
            'code' => $this->code,
            'entities' => $this->entities
        ];
    }
}
