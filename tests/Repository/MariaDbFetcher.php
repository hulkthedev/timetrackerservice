<?php

namespace App\Tests\Repository;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class MariaDbFetcher
{
    /**
     * @return array
     */
    public static function get(): array
    {
        return [static::getAll()[0]];
    }

    /**
     * @return array
     */
    public static function getAll(): array
    {
        return [
            [
                'id' => '1',
                'employer_id' => '1',
                'employer_working_time_id' => '1',
                'date' => '2020-01-06',
                'mode' => 'working',
                'begin_timestamp' => '1578301680',
                'end_timestamp' => '1578329520',
                'break' => '30',
                'delta' => '0',
                'employer_name' => 'Google',
                'working_time_description' => 'Fulltime',
            ],
            [
                'id' => '2',
                'employer_id' => '1',
                'employer_working_time_id' => '1',
                'date' => '2020-01-07',
                'mode' => 'working',
                'begin_timestamp' => '1578390420',
                'end_timestamp' => '1578419940',
                'break' => '30',
                'delta' => '0',
                'employer_name' => 'Google',
                'working_time_description' => 'Fulltime',
            ],
            [
                'id' => '3',
                'employer_id' => '1',
                'employer_working_time_id' => '1',
                'date' => '2020-01-08',
                'mode' => 'working',
                'begin_timestamp' => '1578470340',
                'end_timestamp' => '1578498900',
                'break' => '30',
                'delta' => '0',
                'employer_name' => 'Google',
                'working_time_description' => 'Fulltime',
            ],
            [
                'id' => '4',
                'employer_id' => '1',
                'employer_working_time_id' => '1',
                'date' => '2020-01-09',
                'mode' => 'working',
                'begin_timestamp' => '1578562980',
                'end_timestamp' => '1578597180',
                'break' => '30',
                'delta' => '0',
                'employer_name' => 'Google',
                'working_time_description' => 'Fulltime',
            ],
            [
                'id' => '5',
                'employer_id' => '1',
                'employer_working_time_id' => '1',
                'date' => '2020-01-10',
                'mode' => 'working',
                'begin_timestamp' => '1578648900',
                'end_timestamp' => '1578680040',
                'break' => '30',
                'delta' => '0',
                'employer_name' => 'Google',
                'working_time_description' => 'Fulltime',
            ]
        ];
    }
}
