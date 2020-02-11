use timetracking;

/**********************************************************************************************************************/
DELIMITER //
CREATE PROCEDURE GetAllEntities (
    IN _employerId SMALLINT
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

/**********************************************************************************************************************/
DELIMITER //
CREATE PROCEDURE DeleteEntity (
    IN _employerId SMALLINT,
    IN _employerWorkingTimeId SMALLINT,
    IN _date DATE
)
BEGIN
    DELETE FROM working_times
    WHERE date = _date
        AND employer_id = _employerId
        AND employer_working_time_id = _employerWorkingTimeId;
END //
DELIMITER ;

/**********************************************************************************************************************/
DELIMITER //
CREATE PROCEDURE SaveEntity (
    IN _employer_id SMALLINT,
    IN _employer_working_time_id SMALLINT,
    IN _date DATE,
    IN _mode VARCHAR(20),
    IN _begin_timestamp INT
)
BEGIN
    INSERT INTO working_times (
         employer_id
        ,employer_working_time_id
        ,date
        ,mode
        ,begin_timestamp
    )
    VALUES (
         _employer_id
        ,_employer_working_time_id
        ,_date
        ,_mode
        ,_begin_timestamp
   );
END //
DELIMITER ;

/**********************************************************************************************************************/
DELIMITER //
CREATE PROCEDURE UpdateEntity (
    IN _employer_id SMALLINT,
    IN _employer_working_time_id SMALLINT,
    IN _date DATE,
    IN _mode VARCHAR(20),
    IN _begin_timestamp INT,
    IN _end_timestamp INT,
    IN _break TINYINT,
    IN _delta SMALLINT
)
BEGIN
    UPDATE working_times
    SET mode = _mode,
        begin_timestamp = _begin_timestamp,
        end_timestamp = _end_timestamp,
        break = _break,
        delta = _delta
    WHERE date = _date
        AND employer_id = _employer_id
        AND employer_working_time_id = _employer_working_time_id;
END //
DELIMITER ;