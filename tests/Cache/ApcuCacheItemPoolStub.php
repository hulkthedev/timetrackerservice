<?php

namespace App\Tests\Cache;

use App\Cache\ApcuCacheItemPool;
use Psr\Cache\CacheItemInterface;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class ApcuCacheItemPoolStub extends ApcuCacheItemPool
{
    private array $pool = [];

    public function __construct()
    {
    }

    /**
     * @inheritDoc
     */
    public function save(CacheItemInterface $item): bool
    {
        $this->pool[$item->getKey()] = $item;
        return true;
    }

    /**
     * @inheritDoc
     */
    public function getItem($key)
    {
        if (!$this->isKeyValid($key)) {
            throw new \InvalidArgumentException('Cache Key contains unsupported character!');
        }

        return $this->hasItem($key)
            ? $this->pool[$key]
            : false;
    }

    /**
     * @inheritDoc
     */
    public function hasItem($key): bool
    {
        return isset($this->pool[$key]);
    }

    /**
     * @inheritDoc
     */
    public function clear(): bool
    {
        $this->pool = [];
    }

    /**
     * @inheritDoc
     */
    public function deleteItem($key)
    {
        if (!$this->isKeyValid($key)) {
            throw new \InvalidArgumentException('Cache Key contains unsupported character!');
        }

        unset($this->pool[$key]);
        return true;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->pool;
    }
}
