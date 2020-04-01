<?php

namespace App\Service;

use Exception;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class ApcuCacheService implements CacheService
{
    /**
     * @throws Exception
     */
    public function __construct()
    {
        if (!extension_loaded('apcu')) {
            throw new Exception();
        }
    }

    /**
     * @inheritDoc
     */
    public function set(string $key, $value, bool $overwrite = true): bool
    {
        if (!$this->isset($key)) {
            return apcu_add($key, $value);
        }

        if ($overwrite) {
            return apcu_store($key, $value);
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function get(string $key)
    {
        if ($this->isset($key)) {
            return apcu_fetch($key);
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function delete(string $key): bool
    {
        return apcu_delete($key);
    }

    /**
     * @inheritDoc
     */
    public function isset(string $key): bool
    {
        return apcu_exists($key);
    }

    public function clear(): void
    {
        apcu_clear_cache();
    }
}
