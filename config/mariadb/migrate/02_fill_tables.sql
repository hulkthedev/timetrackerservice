use timetracking;

INSERT INTO employer
    (name, vacation_days)
VALUES
    ('Arvato', 28);

SET @employer_id = LAST_INSERT_ID();



INSERT INTO employer_working_time
    (employer_id, description, working_time, working_break)
VALUES
    (@employer_id, 'Halbzeit', 240, 15),
    (@employer_id, 'Vollzeit', 462, 30);

SET @working_time_id = LAST_INSERT_ID();



INSERT INTO employer_time_account
    (employer_id, time_account)
VALUES
    (@employer_id, 0);


-- https://www.epochconverter.com/
INSERT INTO working_times
    (employer_id, employer_working_time_id, date, mode, begin_timestamp, end_timestamp, break)
VALUES
    (@employer_id, @working_time_id, '2020-01-01', 'holiday', 0, 0, 0),
    (@employer_id, @working_time_id, '2020-01-02', 'vacation', 0, 0, 0),
    (@employer_id, @working_time_id, '2020-01-03', 'vacation', 0, 0, 0),

    (@employer_id, @working_time_id, '2020-01-06', 'working', 1578301680, 1578329520, 30),
    (@employer_id, @working_time_id, '2020-01-07', 'working', 1578390420, 1578419940, 30),
    (@employer_id, @working_time_id, '2020-01-08', 'working', 1578470340, 1578498900, 30),
    (@employer_id, @working_time_id, '2020-01-09', 'working', 1578562980, 1578597180, 30),
    (@employer_id, @working_time_id, '2020-01-10', 'working', 1578648900, 1578680040, 30),

    (@employer_id, @working_time_id, '2020-01-13', 'working', 1578908340, 1578938640, 30),
    (@employer_id, @working_time_id, '2020-01-14', 'working', 1578993720, 1579025220, 30),
    (@employer_id, @working_time_id, '2020-01-15', 'working', 1579080900, 1579108500, 30),
    (@employer_id, @working_time_id, '2020-01-16', 'working', 1579168080, 1579201980, 30),
    (@employer_id, @working_time_id, '2020-01-17', 'working', 1579253520, 1579284180, 30),

    (@employer_id, @working_time_id, '2020-01-20', 'working', 1579512300, 1579541880, 30),
    (@employer_id, @working_time_id, '2020-01-21', 'working', 1579598880, 1579634400, 30),
    (@employer_id, @working_time_id, '2020-01-22', 'working', 1579680540, 1579705380, 30),
    (@employer_id, @working_time_id, '2020-01-23', 'working', 1579772880, 1579800300, 30),
    (@employer_id, @working_time_id, '2020-01-24', 'working', 1579859340, 1579883940, 30),

    (@employer_id, @working_time_id, '2020-01-27', 'working', 1580117100, 1580145960, 30),
    (@employer_id, @working_time_id, '2020-01-28', 'vacation', 0, 0, 0),
    (@employer_id, @working_time_id, '2020-01-29', 'working', 1580290740, 1580325240, 30),
    (@employer_id, @working_time_id, '2020-01-30', 'working', 1580375880, 1580407620, 30),
    (@employer_id, @working_time_id, '2020-01-31', 'working', 1580462640, 1580488560, 30),

    (@employer_id, @working_time_id, '2020-02-03', 'working', 1580721480, 1580756640, 30),
    (@employer_id, @working_time_id, '2020-02-04', 'working', 1580807880, 1580840220, 30),
    (@employer_id, @working_time_id, '2020-02-05', 'working', 1580881980, 1580929380, 30),
    (@employer_id, @working_time_id, '2020-02-06', 'working', 1580979480, 1581006900, 30),
    (@employer_id, @working_time_id, '2020-02-07', 'working', 1581066840, 1581096900, 30),
    (@employer_id, 2,                '2020-02-07', 'working', 1581098400, 1581109200, 15),
    (@employer_id, @working_time_id, '2020-02-10', 'working', 1581325620, 1581356100, 30);