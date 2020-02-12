<?php

namespace App\Tests\Repository;

use App\Entity\Day;
use App\Entity\Week;
use App\Repository\Exception\DatabaseException;
use App\Repository\Mapper\MariaDbMapper;
use App\Repository\MariaDbTrackingRepository;
use App\Usecase\Modes;
use App\Usecase\ResultCodes;
use PHPUnit\Framework\TestCase;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class MariaDbTrackingRepositoryTest extends TestCase
{
    private MariaDbTrackingRepository $repo;

    protected function setUp(): void
    {
        $this->repo = new MariaDbTrackingRepository(new MariaDbMapper());
    }

    /**
     * @throws DatabaseException
     */
    public function test_getPdoDriver_NoLoginDataIsset_ExpectException(): void
    {
        $this->clearEnv();

        $this->expectException(DatabaseException::class);
        $this->expectExceptionCode(ResultCodes::PDO_EXCEPTION_NO_LOGIN_DATA);

        $this->repo->getAll(1);
    }

    /**
     * @throws DatabaseException
     */
    public function test_getAll_NoDataStored_ExpectException(): void
    {
        $pdo = new PdoStub();
        $pdo->setFetchAllReturnValue([]);

        $this->repo->setPdoDriver($pdo);

        $this->expectException(DatabaseException::class);
        $this->expectExceptionCode(ResultCodes::DATABASE_IS_EMPTY);

        $this->repo->getAll(1);
    }

    /**
     * @throws DatabaseException
     */
    public function test_getAll_ExpectRightMapping(): void
    {
        $pdo = new PdoStub();
        $pdo->setFetchAllReturnValue(MariaDbFetcher::getAll());

        $this->repo->setPdoDriver($pdo);

        $result = $this->repo->getAll(1);

        /** @var Week $week */
        $week = reset($result);
        TestCase::assertInstanceOf(Week::class, $week);
        TestCase::assertInstanceOf(Day::class, reset($week->weekDays[0]));
        TestCase::assertEquals(5, count($week->weekDays));
        TestCase::assertEquals(2, $week->weekNo);
    }

    /**
     * @throws DatabaseException
     */
    public function test_getByDate_ExpectException(): void
    {
        $pdo = new PdoStub();
        $pdo->setFetchAllReturnValue([]);

        $this->repo->setPdoDriver($pdo);

        $this->expectException(DatabaseException::class);
        $this->expectExceptionCode(ResultCodes::ENTITY_NOT_FOUND);

        $this->repo->getByDate('2020-01-06', 1);
    }

    /**
     * @throws DatabaseException
     */
    public function test_getByDate_ExpectRightMapping(): void
    {
        $pdo = new PdoStub();
        $pdo->setFetchAllReturnValue(MariaDbFetcher::get());

        $this->repo->setPdoDriver($pdo);

        $result = $this->repo->getByDate('2020-01-06', 1);

        /** @var Week $week */
        $week = reset($result);
        TestCase::assertInstanceOf(Week::class, $week);
        TestCase::assertInstanceOf(Day::class, reset($week->weekDays[0]));
        TestCase::assertEquals(1, count($week->weekDays));
        TestCase::assertEquals(2, $week->weekNo);
    }

    /**
     * @throws DatabaseException
     */
    public function test_getById_ExpectException(): void
    {
        $pdo = new PdoStub();
        $pdo->setFetchAllReturnValue([]);

        $this->repo->setPdoDriver($pdo);

        $this->expectException(DatabaseException::class);
        $this->expectExceptionCode(ResultCodes::ENTITY_NOT_FOUND);

        $this->repo->getById('2020-01-016', 1, 1);
    }

    /**
     * @throws DatabaseException
     */
    public function test_getById_ExpectRightMapping(): void
    {
        $pdo = new PdoStub();
        $pdo->setFetchAllReturnValue(MariaDbFetcher::get());

        $this->repo->setPdoDriver($pdo);

        $result = $this->repo->getById('2020-01-06', 1, 1);

        /** @var Day $day */
        $day = reset($result);
        TestCase::assertInstanceOf(Day::class, $day);
        TestCase::assertEquals('2020-01-06', $day->date);
        TestCase::assertEquals(Modes::MODE_WORKING, $day->mode);
        TestCase::assertEquals('09:08:00', $day->begin);
        TestCase::assertEquals('16:52:00', $day->end);
        TestCase::assertEquals(0, $day->delta);
        TestCase::assertEquals(1, $day->employerId);
        TestCase::assertEquals('Google', $day->employerName);
        TestCase::assertEquals(1, $day->workingTimeId);
        TestCase::assertEquals('Fulltime', $day->workingTimeDescription);
    }

    /**
     * @throws DatabaseException
     */
    public function test_delete_ExpectException(): void
    {
        $pdo = new PdoStub();
        $pdo->setExecuteReturnValue(false);

        $this->repo->setPdoDriver($pdo);

        $this->expectException(DatabaseException::class);
        $this->expectExceptionCode(ResultCodes::ENTITY_CAN_NOT_BE_DELETED);

        $this->repo->delete('2020-01-01', 1, 1);
    }

    /**
     * @throws DatabaseException
     */
    public function test_delete_ExpectNoError(): void
    {
        $pdo = new PdoStub();
        $pdo->setExecuteReturnValue(true);

        $this->repo->setPdoDriver($pdo);

        $result = $this->repo->delete('2020-01-01', 1, 1);
        TestCase::assertTrue($result);
    }

    /**
     * @throws DatabaseException
     */
    public function test_save_ExpectException(): void
    {
        $pdo = new PdoStub();
        $pdo->setExecuteReturnValue(false);

        $this->repo->setPdoDriver($pdo);

        $this->expectException(DatabaseException::class);
        $this->expectExceptionCode(ResultCodes::ENTITY_CAN_NOT_BE_SAVED);

        $this->repo->save('2020-01-01', 1, 1, Modes::MODE_WORKING, 1579080900);
    }

    /**
     * @throws DatabaseException
     */
    public function test_save_ExpectNoError(): void
    {
        $pdo = new PdoStub();
        $pdo->setExecuteReturnValue(true);

        $this->repo->setPdoDriver($pdo);

        $result = $this->repo->save('2020-01-01', 1, 1, Modes::MODE_WORKING, 1579080900);
        TestCase::assertTrue($result);
    }

    /**
     * @throws DatabaseException
     */
    public function test_update_ExpectException(): void
    {
        $pdo = new PdoStub();
        $pdo->setExecuteReturnValue(false);

        $this->repo->setPdoDriver($pdo);

        $this->expectException(DatabaseException::class);
        $this->expectExceptionCode(ResultCodes::ENTITY_CAN_NOT_BE_UPDATED);

        $this->repo->update('2020-01-01', 1, 1, Modes::MODE_WORKING, 1579080900, 1579108500, 30, 0);
    }

    /**
     * @throws DatabaseException
     */
    public function test_update_ExpectRightMapping(): void
    {
        $pdo = new PdoStub();
        $pdo->setExecuteReturnValue(true);

        $this->repo->setPdoDriver($pdo);

        $result = $this->repo->update('2020-01-01', 1, 1, Modes::MODE_WORKING, 1579080900, 1579108500, 30, 0);
        TestCase::assertTrue($result);
    }

    private function clearEnv(): void
    {
        putenv('MARIADB_HOST');
        putenv('MARIADB_USER');
        putenv('MARIADB_PASSWORD');
        putenv('MARIADB_NAME');
        putenv('MARIADB_PORT');
    }
}
