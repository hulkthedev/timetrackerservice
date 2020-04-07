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

## Example Response

> [GET](http://localhost:3699/timetracking/1) /timetracking/1
```json
{
    "code": 1,
    "entities": [
        {
            "no": 15,
            "delta": 30,
            "deltaFormatted": "00:30",
            "days": [
                {
                    "weekday": 1,
                    "date": "2020-04-06",
                    "begin": "08:00",
                    "end": "16:30",
                    "mode": "working",
                    "delta": 0,
                    "break": 30,
                    "employerId": 1,
                    "employerName": "NASA",
                    "workingTimeId": 1,
                    "workingTimeDescription": "FullTime"
                },
                {
                    "weekday": 4,
                    "date": "2020-04-07",
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
                    "date": "2020-04-08",
                    "begin": "08:00",
                    "end": "17:00",
                    "mode": "home_office",
                    "delta": 30,
                    "break": 30,
                    "employerId": 1,
                    "employerName": "NASA",
                    "workingTimeId": 1,
                    "workingTimeDescription": "FullTime"
                },
                {
                    "weekday": 4,
                    "date": "2020-04-09",
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
                    "date": "2020-04-10",
                    "begin": "08:00",
                    "end": "16:30",
                    "mode": "working",
                    "delta": 0,
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