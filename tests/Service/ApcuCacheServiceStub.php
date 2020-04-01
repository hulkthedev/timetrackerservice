<?php

namespace App\Tests\Service;

use App\Service\ApcuCacheService;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class ApcuCacheServiceStub extends ApcuCacheService
{
    private array $store = [];

    public function __construct()
    {
    }

    /**
     * @inheritDoc
     */
    public function set(string $key, $value, bool $overwrite = true): bool
    {
        $this->store[$key] = $value;
        return true;
    }

    /**
     * @inheritDoc
     */
    public function get(string $key)
    {
        return $this->isset($key)
            ? $this->store[$key]
            : false;
    }

    /**
     * @inheritDoc
     */
    public function delete(string $key): bool
    {
        unset($this->store[$key]);
        return true;
    }

    /**
     * @inheritDoc
     */
    public function isset(string $key): bool
    {
        return isset($this->store[$key]);
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->store;
    }

    public function clear(): void
    {
        $this->store = [];
    }
}