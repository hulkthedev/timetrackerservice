# TimeTracker Service

[![Version](https://img.shields.io/badge/Version-1.0.0-blue)](https://github.com/hulkthedev/timetrackerservice)
[![Build Status](https://travis-ci.org/hulkthedev/timetrackerservice.svg?branch=develop)](https://travis-ci.org/hulkthedev/timetrackerservice)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=hulkthedev_timetrackerservice&metric=alert_status)](https://sonarcloud.io/dashboard?id=hulkthedev_timetrackerservice)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=hulkthedev_timetrackerservice&metric=coverage)](https://sonarcloud.io/dashboard?id=hulkthedev_timetrackerservice)
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](https://opensource.org/licenses/MIT)

A REST based time tracking service. 
Supports multiple shifts per employer with freely configurable work and break times. 
Automatic time and vacation account management. 

## Build

```bash
./build/build.sh
```

## Testing

```bash
./build/phpunit.sh
```

## Operations

* **GET**
    * getAll
    * getById
    * getByDate
* **PUT**
    * add
* **PATCH**
    * updateById
* **DELETE**
    * updateById

## Example Responses

> [GET](http://localhost:3699/timetracking/1) /timetracking/{employerId}
```json
{
    "code": 1,
    "entities": [
        {
            "no": 1,
            "delta": 0,
            "deltaFormatted": "00:00",
            "days": [
                {
                    "weekday": 4,
                    "date": "2020-01-01",
                    "begin": "00:00",
                    "end": "00:00",
                    "mode": "holiday",
                    "delta": 0,
                    "break": 0,
                    "employerId": 1,
                    "employerName": "NASA",
                    "workingTimeId": 1,
                    "workingTimeDescription": "FullTime"
                },
                {
                    "weekday": 4,
                    "date": "2020-01-02",
                    "begin": "00:00",
                    "end": "00:00",
                    "mode": "vacation",
                    "delta": 0,
                    "break": 0,
                    "employerId": 1,
                    "employerName": "NASA",
                    "workingTimeId": 1,
                    "workingTimeDescription": "FullTime"
                },
                {
                    "weekday": 4,
                    "date": "2020-01-03",
                    "begin": "08:00",
                    "end": "17:00",
                    "mode": "working",
                    "delta": 30,
                    "break": 30,
                    "employerId": 1,
                    "employerName": "NASA",
                    "workingTimeId": 1,
                    "workingTimeDescription": "FullTime"
                }
            ]
        }
    ]
}
```