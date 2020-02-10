use timetracking;

/**********************************************************************************************************************/
DELIMITER //
CREATE PROCEDURE GetAllEntities (
    IN _employerId SMALLINT
)
BEGIN
    IF(_employerId = 0) THEN
        SET _employerId = 1;
    END IF;

    SELECT
         wrk_tms.id
        ,wrk_tms.employer_id
        ,wrk_tms.employer_working_time_id
        ,wrk_tms.date
        ,wrk_tms.mode
        ,wrk_tms.begin_timestamp
        ,wrk_tms.end_timestamp
        ,wrk_tms.break
        ,wrk_tms.delta
        ,empl.name AS employer_name
        ,empl_wrktm.description AS working_time_description
    FROM employer AS empl
            INNER JOIN working_times AS wrk_tms
                ON empl.id = wrk_tms.employer_id
            INNER JOIN employer_working_time AS empl_wrktm
                ON empl.id = empl_wrktm.employer_id
                    AND wrk_tms.employer_working_time_id = empl_wrktm.id
    WHERE wrk_tms.employer_id = _employerId
    LIMIT 100;
END //
DELIMITER ;

/**********************************************************************************************************************/
DELIMITER //
CREATE PROCEDURE GetEntityByDate (
    IN _employerId SMALLINT,
    IN _date DATE
)
BEGIN
    SELECT
         wrk_tms.id
        ,wrk_tms.employer_id
        ,wrk_tms.employer_working_time_id
        ,wrk_tms.date
        ,wrk_tms.mode
        ,wrk_tms.begin_timestamp
        ,wrk_tms.end_timestamp
        ,wrk_tms.break
        ,wrk_tms.delta
        ,empl.name AS employer_name
        ,empl_wrktm.description AS working_time_description
    FROM employer AS empl
             INNER JOIN working_times AS wrk_tms
                ON empl.id = wrk_tms.employer_id
             INNER JOIN employer_working_time AS empl_wrktm
                ON empl.id = empl_wrktm.employer_id
                    AND wrk_tms.employer_working_time_id = empl_wrktm.id
    WHERE empl.id = _employerId
        AND wrk_tms.date = _date;
END //
DELIMITER ;

/**********************************************************************************************************************/
DELIMITER //
CREATE PROCEDURE GetEntityById (
    IN _employerId SMALLINT,
    IN _employerWorkingTimeId SMALLINT,
    IN _date DATE
)
BEGIN
    SELECT
         wrk_tms.id
        ,wrk_tms.employer_id
        ,wrk_tms.employer_working_time_id
        ,wrk_tms.date
        ,wrk_tms.mode
        ,wrk_tms.begin_timestamp
        ,wrk_tms.end_timestamp
        ,wrk_tms.break
        ,wrk_tms.delta
        ,empl.name AS employer_name
        ,empl_wrktm.description AS working_time_description
    FROM employer AS empl
             INNER JOIN working_times AS wrk_tms
                ON empl.id = wrk_tms.employer_id
             INNER JOIN employer_working_time AS empl_wrktm
                ON empl.id = empl_wrktm.employer_id
                    AND wrk_tms.employer_working_time_id = empl_wrktm.id
    WHERE empl.id = _employerId
        AND wrk_tms.date = _date
        AND wrk_tms.employer_working_time_id = _employerWorkingTimeId;
END //
DELIMITER ;
