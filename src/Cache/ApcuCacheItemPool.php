<?php

namespace App\Cache;

use App\Cache\Exception\ExtensionNotFoundException;
use InvalidArgumentException;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 * @codeCoverageIgnore
 */
class ApcuCacheItemPool implements CacheItemPoolInterface
{
    /**
     * @throws ExtensionNotFoundException
     */
    public function __construct()
    {
        if (!extension_loaded('apcu')) {
            throw new ExtensionNotFoundException();
        }
    }

    /**
     * @inheritDoc
     */
    public function getItem($key)
    {
        if (!$this->isKeyValid($key)) {
            throw new InvalidArgumentException('Cache Key contains unsupported character!');
        }

        return apcu_fetch($key);
    }

    /**
     * @inheritDoc
     */
    public function getItems(array $keys = []): array
    {
        $collection = [];
        foreach ($keys as $key) {
            $collection[] = $this->getItem($key);
        }

        return $collection;
    }

    /**
     * @inheritDoc
     */
    public function hasItem($key): bool
    {
        return apcu_exists($key);
    }

    /**
     * @inheritDoc
     */
    public function clear(): bool
    {
        return apcu_clear_cache();
    }

    /**
     * @inheritDoc
     */
    public function deleteItem($key)
    {
        if (!$this->isKeyValid($key)) {
            throw new InvalidArgumentException('Cache Key contains unsupported character!');
        }

        return apcu_delete($key);
    }

    /**
     * @inheritDoc
     */
    public function deleteItems(array $keys)
    {
        foreach ($keys as $key) {
            if (!$this->deleteItem($key)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function save(CacheItemInterface $item): bool
    {
        return apcu_store($item->getKey(), $item, $item->getExpiry());
    }

    /**
     * @inheritDoc
     */
    public function saveDeferred(CacheItemInterface $item): bool
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function commit(): bool
    {
        return false;
    }

    /**
     * @param string $key
     * @return false
     */
    protected function isKeyValid(string $key): bool
    {
        return (bool) preg_match('/^[\w+]{4,30}$/', $key);
    }
}
