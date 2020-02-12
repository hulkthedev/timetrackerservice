<?php

namespace App\Repository;

use App\Repository\Exception\DatabaseException;
use App\Repository\Mapper\MariaDbMapper as Mapper;
use App\Usecase\ResultCodes;
use PDO;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class MariaDbTrackingRepository implements RepositoryInterface
{
    private const STORED_PROCEDURE_SAVE = 'CALL SaveEntity(:employerId, :employerWorkingTimeId, :date, :mode, :begin_timestamp)';
    private const STORED_PROCEDURE_UPDATE = 'CALL UpdateEntity(:employerId, :employerWorkingTimeId, :date, :mode, :begin_timestamp, :end_timestamp, :break, :delta)';
    private const STORED_PROCEDURE_DELETE = 'CALL DeleteEntity(:employerId, :employerWorkingTimeId, :date)';
    private const STORED_PROCEDURE_GET_ALL = 'CALL GetAllEntities(:employerId)';
    private const STORED_PROCEDURE_GET_BY_ID = 'CALL GetEntityById(:employerId, :employerWorkingTimeId, :date)';
    private const STORED_PROCEDURE_GET_BY_DATE = 'CALL GetEntityByDate(:employerId, :date)';

    private const DATABASE_CONNECTION_TIMEOUT = 30;

    private ?PDO $pdo = null;
    private Mapper $mapper;

    /**
     * @param Mapper $mapper
     */
    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @inheritDoc
     */
    public function getAll(int $employerId): array
    {
        $statement = $this->getPdoDriver()->prepare(self::STORED_PROCEDURE_GET_ALL);
        $statement->execute(['employerId' => $employerId]);

        $list = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (empty($list)) {
            throw new DatabaseException(ResultCodes::DATABASE_IS_EMPTY);
        }

        return $this->mapper->mapToList($list);
    }

    /**
     * @inheritDoc
     */
    public function getByDate(string $date, int $employerId): array
    {
        $statement = $this->getPdoDriver()->prepare(self::STORED_PROCEDURE_GET_BY_DATE);
        $statement->execute([
            'date' => $date,
            'employerId' => $employerId
        ]);

        $entity = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (empty($entity)) {
            throw new DatabaseException(ResultCodes::ENTITY_NOT_FOUND);
        }

        return $this->mapper->mapToList($entity);
    }

    /**
     * @inheritDoc
     */
    public function getById(string $date, int $employerId, int $employerWorkingTimeId): array
    {
        $statement = $this->getPdoDriver()->prepare(self::STORED_PROCEDURE_GET_BY_ID);
        $statement->execute([
            'date' => $date,
            'employerId' => $employerId,
            'employerWorkingTimeId' => $employerWorkingTimeId
        ]);

        $entity = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (empty($entity)) {
            throw new DatabaseException(ResultCodes::ENTITY_NOT_FOUND);
        }

        return [$this->mapper->mapEntityToDay(reset($entity))];
    }

    /**
     * @inheritDoc
     */
    public function delete(string $date, int $employerId, int $employerWorkingTimeId): bool
    {
        $statement = $this->getPdoDriver()->prepare(self::STORED_PROCEDURE_DELETE);
        $result = $statement->execute([
            'date' => $date,
            'employerId' => $employerId,
            'employerWorkingTimeId' => $employerWorkingTimeId
        ]);

        if (true !== $result) {
            throw new DatabaseException(ResultCodes::ENTITY_CAN_NOT_BE_DELETED);
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function save(string $date, int $employerId, int $employerWorkingTimeId, string $mode, int $beginTimestamp): bool
    {
        $statement = $this->getPdoDriver()->prepare(self::STORED_PROCEDURE_SAVE);
        $result = $statement->execute([
            'date' => $date,
            'employerId' => $employerId,
            'employerWorkingTimeId' => $employerWorkingTimeId,
            'mode' => $mode,
            'begin_timestamp' => $beginTimestamp
        ]);

        if (true !== $result) {
            throw new DatabaseException(ResultCodes::ENTITY_CAN_NOT_BE_SAVED);
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function update(string $date, int $employerId, int $employerWorkingTimeId, string $mode, int $beginTimestamp, int $endTimestamp, int $break, int $delta): bool
    {
        $statement = $this->getPdoDriver()->prepare(self::STORED_PROCEDURE_UPDATE);
        $result = $statement->execute([
            'date' => $date,
            'employerId' => $employerId,
            'employerWorkingTimeId' => $employerWorkingTimeId,
            'mode' => $mode,
            'begin_timestamp' => $beginTimestamp,
            'end_timestamp' => $endTimestamp,
            'break' => $break,
            'delta' => $delta
        ]);

        if (true !== $result) {
            throw new DatabaseException(ResultCodes::ENTITY_CAN_NOT_BE_UPDATED);
        }

        return true;
    }

    /**
     * @return PDO
     * @throws DatabaseException
     */
    private function getPdoDriver(): PDO
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

    /**
     * @param PDO $pdo
     */
    public function setPdoDriver(PDO $pdo): void
    {
        $this->pdo = $pdo;
    }
}
