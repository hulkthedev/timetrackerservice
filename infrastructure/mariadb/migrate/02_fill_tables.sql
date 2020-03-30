use timetracking;

INSERT INTO employer
    (name, vacation_days)
VALUES
    ('Arvato', 28);

SET @employer_id = LAST_INSERT_ID();



INSERT INTO employer_working_time
    (employer_id, description, working_time, working_break)
VALUES
    (@employer_id, 'Vollzeit', 462, 30);

SET @working_time_id = LAST_INSERT_ID();



INSERT INTO employer_time_account
    (employer_id, time_account)
VALUES
    (@employer_id, 253);


-- https://www.epochconverter.com/
INSERT INTO working_times
    (employer_id, employer_working_time_id, date, mode, begin_timestamp, end_timestamp, break, delta)
VALUES
    (@employer_id, @working_time_id, '2020-01-01', 'holiday',  0, 0, 0, 0),
    (@employer_id, @working_time_id, '2020-01-02', 'vacation', 0, 0, 0, 0),
    (@employer_id, @working_time_id, '2020-01-03', 'vacation', 0, 0, 0, 0),

    (@employer_id, @working_time_id, '2020-01-06', 'working', 1578301680, 1578329520, 30, -28),
    (@employer_id, @working_time_id, '2020-01-07', 'working', 1578390420, 1578419940, 30,   0),
    (@employer_id, @working_time_id, '2020-01-08', 'working', 1578470340, 1578498900, 30, -16),
    (@employer_id, @working_time_id, '2020-01-09', 'working', 1578562980, 1578597180, 30,  78),
    (@employer_id, @working_time_id, '2020-01-10', 'working', 1578648900, 1578680040, 30,  27),

    (@employer_id, @working_time_id, '2020-01-13', 'working', 1578908340, 1578938640, 30,  13),
    (@employer_id, @working_time_id, '2020-01-14', 'working', 1578993720, 1579025220, 30,  33),
    (@employer_id, @working_time_id, '2020-01-15', 'working', 1579080900, 1579108500, 30, -32),
    (@employer_id, @working_time_id, '2020-01-16', 'working', 1579168080, 1579201980, 30,  73),
    (@employer_id, @working_time_id, '2020-01-17', 'working', 1579253520, 1579284180, 30,  19),

    (@employer_id, @working_time_id, '2020-01-20', 'working', 1579512300, 1579541880, 30,   1),
    (@employer_id, @working_time_id, '2020-01-21', 'working', 1579598880, 1579634400, 30, 100),
    (@employer_id, @working_time_id, '2020-01-22', 'working', 1579680540, 1579705380, 30, -78),
    (@employer_id, @working_time_id, '2020-01-23', 'working', 1579772880, 1579800300, 30, -35),
    (@employer_id, @working_time_id, '2020-01-24', 'working', 1579859340, 1579883940, 30, -87),

    (@employer_id, @working_time_id, '2020-01-27', 'working', 1580117100, 1580145960, 30, -11),
    (@employer_id, @working_time_id, '2020-01-28', 'vacation', 0, 0, 0, 0),
    (@employer_id, @working_time_id, '2020-01-29', 'working', 1580290740, 1580325240, 30,  83),
    (@employer_id, @working_time_id, '2020-01-30', 'working', 1580375880, 1580407620, 30,  37),
    (@employer_id, @working_time_id, '2020-01-31', 'working', 1580462640, 1580488560, 30, -60),

    (@employer_id, @working_time_id, '2020-02-03', 'working', 1580721480, 1580756640, 30,  94),
    (@employer_id, @working_time_id, '2020-02-04', 'working', 1580807880, 1580840220, 30,  47),
    (@employer_id, @working_time_id, '2020-02-05', 'working', 1580881980, 1580929380, 30, 118),
    (@employer_id, @working_time_id, '2020-02-06', 'working', 1580979480, 1581006900, 30, -35),
    (@employer_id, @working_time_id, '2020-02-07', 'working', 1581066840, 1581096900, 30,   9),

    (@employer_id, @working_time_id, '2020-02-10', 'working', 1581325620, 1581356100, 30,  16),
    (@employer_id, @working_time_id, '2020-02-11', 'working', 1581412560, 1581441420, 30, -11),
    (@employer_id, @working_time_id, '2020-02-12', 'working', 1581500340, 1581535440, 30,  93),
    (@employer_id, @working_time_id, '2020-02-13', 'working', 1581584640, 1581609900, 30, -71),
    (@employer_id, @working_time_id, '2020-02-14', 'working', 1581671880, 1581694620, 30, -98),

    (@employer_id, @working_time_id, '2020-02-17', 'working', 1581930360, 1581962700, 30, 47),
    (@employer_id, @working_time_id, '2020-02-18', 'working', 1582018680, 1582052640, 30, 59),
    (@employer_id, @working_time_id, '2020-02-19', 'sick', 0, 0, 0, 0),
    (@employer_id, @working_time_id, '2020-02-20', 'sick', 0, 0, 0, 0),
    (@employer_id, @working_time_id, '2020-02-21', 'working', 1582277880, 1582310280, 30, 48),

    (@employer_id, @working_time_id, '2020-02-24', 'working', 1582540140, 1582567020, 30, -44),
    (@employer_id, @working_time_id, '2020-02-25', 'working', 1582624140, 1582652640, 30, -17),
    (@employer_id, @working_time_id, '2020-02-26', 'working', 1582704000, 1582737480, 30, 51),
    (@employer_id, @working_time_id, '2020-02-27', 'working', 1582795080, 1582819140, 30, -91),
    (@employer_id, @working_time_id, '2020-02-28', 'working', 1582883280, 1582907160, 30, -94),

    (@employer_id, @working_time_id, '2020-03-02', 'working', 1583140920, 1583170980, 30, 9),
    (@employer_id, @working_time_id, '2020-03-03', 'working', 1583227080, 1583258700, 30, 35),
    (@employer_id, @working_time_id, '2020-03-04', 'working', 1583314440, 1583345040, 30, 18),
    (@employer_id, @working_time_id, '2020-03-05', 'working', 1583400540, 1583426100, 30, -66),
    (@employer_id, @working_time_id, '2020-03-06', 'working', 1583486880, 1583510880, 30, -92),

    (@employer_id, @working_time_id, '2020-03-09', 'working', 1583745180, 1583777220, 30, 42),
    (@employer_id, @working_time_id, '2020-03-10', 'working', 1583831940, 1583863560, 30, 35),
    (@employer_id, @working_time_id, '2020-03-11', 'working', 1583919480, 1583952240, 30, 39),
    (@employer_id, @working_time_id, '2020-03-12', 'working', 1584005940, 1584029100, 30, -106),
    (@employer_id, @working_time_id, '2020-03-13', 'vacation', 0, 0, 0, 0),

    (@employer_id, @working_time_id, '2020-03-16', 'working', 1584348840, 1584379440, 30, 18),
    (@employer_id, @working_time_id, '2020-03-17', 'home_office', 1584437400, 1584468000, 30, 0),
    (@employer_id, @working_time_id, '2020-03-18', 'home_office', 1584523800, 1584554400, 30, 0),
    (@employer_id, @working_time_id, '2020-03-19', 'home_office', 1584610200, 1584640800, 30, 0),
    (@employer_id, @working_time_id, '2020-03-20', 'home_office', 1584696600, 1584727200, 30, 0),

    (@employer_id, @working_time_id, '2020-03-23', 'home_office', 1584955800, 1584986100, 30, 0),
    (@employer_id, @working_time_id, '2020-03-24', 'home_office', 1585042200, 1585072500, 30, 0),
    (@employer_id, @working_time_id, '2020-03-25', 'home_office', 1585128600, 1585158900, 30, 0),
    (@employer_id, @working_time_id, '2020-03-26', 'home_office', 1585211400, 1585241700, 30, 0),
    (@employer_id, @working_time_id, '2020-03-27', 'home_office', 1585301400, 1585331700, 30, 0);