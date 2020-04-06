<?php

namespace App\Repository;

use App\Cache\ApcuCacheItemPool;
use App\Cache\CacheItem;
use App\Repository\Exception\DatabaseException;
use App\Repository\Mapper\MariaDbMapper as Mapper;
use App\Usecase\ResultCodes;
use PDO;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException as CacheInvalidArgumentException;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class MariaDbBaseRepository
{
    private const DATABASE_CONNECTION_TIMEOUT = 30;
    private const CACHE_TTL_IN_SECONDS = 86400; // 24h

    private ?PDO $pdo = null;
    private Mapper $mapper;
    private ApcuCacheItemPool $cachePool;

    /**
     * @param Mapper $mapper
     * @param ApcuCacheItemPool $cachePool
     */
    public function __construct(Mapper $mapper, ApcuCacheItemPool $cachePool)
    {
        $this->mapper = $mapper;
        $this->cachePool = $cachePool;
    }

    /**
     * @info for unittests only
     * @param PDO $pdo
     */
    public function setPdoDriver(PDO $pdo): void
    {
        $this->pdo = $pdo;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param int $expireAt
     * @return bool
     */
    protected function saveInCachePool(string $key, $value, int $expireAt = self::CACHE_TTL_IN_SECONDS): bool
    {
        $item = new CacheItem($key);
        $item->set($value)
            ->expiresAfter($expireAt);

        return $this->getCache()->save($item);
    }

    /**
     * @param string $key
     * @return mixed
     */
    protected function getFromCachePool(string $key)
    {
        try {
            /** @var CacheItem $item */
            if (false !== $item = $this->getCache()->getItem($key)) {
                return $item->get();
            }
        } catch (CacheInvalidArgumentException $exception) {
        }

        return false;
    }

    /**
     * @param string $key
     * @return bool
     */
    protected function deleteFromCachePool(string $key): bool
    {
        try {
            return $this->getCache()->deleteItem($key);
        } catch (CacheInvalidArgumentException $exception) {
            return false;
        }
    }

    /**
     * @return CacheItemPoolInterface
     */
    protected function getCache(): CacheItemPoolInterface
    {
        return $this->cachePool;
    }

    /**
     * @return Mapper
     */
    protected function getMapper(): Mapper
    {
        return $this->mapper;
    }

    /**
     * @return PDO
     * @throws DatabaseException
     * @codeCoverageIgnore
     */
    protected function getPdoDriver(): PDO
    {
        if (null === $this->pdo) {
            $host = getenv('MARIADB_HOST');
            $user = getenv('MARIADB_USER');
            $password = getenv('MARIADB_PASSWORD');
            $name = getenv('MARIADB_NAME');
            $port = getenv('MARIADB_PORT');

            if (empty($host) || empty($user) || empty($password) || empty($name) || empty($port)) {
                throw new DatabaseException(ResultCodes::PDO_EXCEPTION_NO_LOGIN_DATA);
            }

            $this->pdo = new PDO("mysql:dbname=$name;host=$host;port=$port;charset=utf8mb4", $user, $password, [
                PDO::ATTR_TIMEOUT => self::DATABASE_CONNECTION_TIMEOUT
            ]);
        }

        return $this->pdo;
    }
}
