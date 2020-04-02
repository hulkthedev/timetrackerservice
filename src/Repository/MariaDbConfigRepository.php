<?php

namespace App\Repository;

use App\Cache\CacheItem;
use App\Entity\Config;
use App\Repository\Exception\DatabaseException;
use App\Usecase\ResultCodes;
use PDO;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class MariaDbConfigRepository extends MariaDbBaseRepository
{
    private const STORED_PROCEDURE_GET_CONFIG = 'CALL GetEmployerConfig(:employerId, :employerWorkingTimeId)';

    /**
     * @param int $employerId
     * @param int $employerWorkingTimeId
     * @return Config
     * @throws DatabaseException
     */
    public function getConfig(int $employerId, int $employerWorkingTimeId): Config
    {
        $key = CacheItem::PREFIX_CONFIG . "{$employerId}_{$employerWorkingTimeId}";
        if (false !== $config = $this->getFromCachePool($key)) {
            return $config;
        }

        $config = $this->getFromRepo($employerId, $employerWorkingTimeId);
        $this->saveInCachePool($key, $config, (86400*7)); // 1w

        return $config;
    }

    /**
     * @param int $employerId
     * @param int $employerWorkingTimeId
     * @return Config
     * @throws DatabaseException
     */
    protected function getFromRepo(int $employerId, int $employerWorkingTimeId): Config
    {
        $statement = $this->getPdoDriver()->prepare(self::STORED_PROCEDURE_GET_CONFIG);
        $result = $statement->execute([
            'employerId' => $employerId,
            'employerWorkingTimeId' => $employerWorkingTimeId,
        ]);

        if (true !== $result) {
            throw new DatabaseException(ResultCodes::PDO_EXCEPTION);
        }

        $config = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $this->getMapper()->mapToConfig(reset($config));
    }
}
