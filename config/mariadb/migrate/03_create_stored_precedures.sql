use timetracking;

DELIMITER //

CREATE PROCEDURE GetEntity (
    IN _employerId INT,
    IN _date DATE
)
BEGIN
    SELECT *
    FROM working_times wt
    LEFT JOIN employer empl ON wt.employer_id = employer.id
    WHERE wt.employer_id = _employerId
    AND date = _date;
END //

DELIMITER ;
