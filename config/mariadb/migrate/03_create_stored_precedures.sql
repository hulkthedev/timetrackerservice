use timetracking;

DELIMITER //

CREATE PROCEDURE GetEntity (
    IN _employerId INT,
    IN _date DATE
)
BEGIN
    SELECT *
    FROM working_times
    WHERE employer_id = _employerId
    AND date = _date;
END //

DELIMITER ;
