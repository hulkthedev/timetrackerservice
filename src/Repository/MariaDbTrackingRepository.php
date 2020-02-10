<?php

namespace App\Repository;

use App\Repository\Exception\DatabaseException;
use App\Repository\Mapper\MariaDbToJsonMapper as Mapper;
use App\Usecase\AddEntity\AddEntityRequest;
use App\Usecase\DeleteEntity\DeleteEntityRequest;
use App\Usecase\ResultCodes;
use App\Usecase\UpdateEntity\UpdateEntityRequest;
use PDO;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class MariaDbTrackingRepository implements RepositoryInterface
{
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
        $statement = $this->getPdoDriver()->prepare('CALL GetAllEntities(:employerId)');
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
        $statement = $this->getPdoDriver()->prepare('CALL GetEntityByDate(:employerId, :date)');
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
        $statement = $this->getPdoDriver()->prepare('CALL GetEntityById(:employerId, :employerWorkingTimeId, :date)');
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
    public function save(AddEntityRequest $request): void
    {
        $query = '';
        $statement = $this->getPdoDriver()->prepare($query);

        $result = $statement->execute([
            'date' => $request->date,
            'mode' => $request->mode,
            'begin_timestamp' => $request->begin
        ]);

        if (true !== $result) {
            throw new DatabaseException(ResultCodes::ENTITY_CAN_NOT_BE_SAVED);
        }
    }

    /**
     * @inheritDoc
     */
    public function update(UpdateEntityRequest $request): void
    {
        /**
         * @todo fix PATCH Bug && add logic
         */

        $result = true;

        if (true !== $result) {
            throw new DatabaseException(ResultCodes::ENTITY_CAN_NOT_BE_UPDATED);
        }
    }

    /**
     * @inheritDoc
     */
    public function delete(string $date, int $employerId, int $employerWorkingTimeId): void
    {
        $statement = $this->getPdoDriver()->prepare('CALL DeleteEntity(:employerId, :employerWorkingTimeId, :date)');
        $result = $statement->execute([
            'date' => $date,
            'employerId' => $employerId,
            'employerWorkingTimeId' => $employerWorkingTimeId
        ]);

        if (true !== $result) {
            throw new DatabaseException(ResultCodes::ENTITY_CAN_NOT_BE_DELETED);
        }
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
                throw new DatabaseException(ResultCodes::PDO_EXCEPTION);
            }

            $this->pdo = new PDO("mysql:dbname=$name;host=$host;port=$port;charset=utf8mb4", $user, $password, [
                PDO::ATTR_TIMEOUT => self::DATABASE_CONNECTION_TIMEOUT
            ]);
        }

        return $this->pdo;
    }
}
