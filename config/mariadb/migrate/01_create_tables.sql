CREATE TABLE employer (
    id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    vacation_days TINYINT UNSIGNED NOT NULL,

    CONSTRAINT unique_employer UNIQUE (name)
);

CREATE TABLE employer_working_time (
    id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    employer_id SMALLINT UNSIGNED NOT NULL,
    description VARCHAR(30) NOT NULL,
    working_time SMALLINT UNSIGNED NOT NULL,
    working_break TINYINT UNSIGNED NOT NULL,

    CONSTRAINT unique_working_time UNIQUE (employer_id, working_time),
    CONSTRAINT fk_employer_working_time FOREIGN KEY (employer_id) REFERENCES employer (id)
);

CREATE TABLE employer_time_account (
    employer_id SMALLINT UNSIGNED NOT NULL PRIMARY KEY,
    time_account SMALLINT NOT NULL,

    CONSTRAINT unique_time_account UNIQUE (employer_id),
    CONSTRAINT fk_employer_time_account FOREIGN KEY (employer_id) REFERENCES employer (id)
);

CREATE TABLE working_times (
    id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    employer_id SMALLINT UNSIGNED NOT NULL,
    employer_working_time_id SMALLINT UNSIGNED NOT NULL,
    date DATE NOT NULL,
    mode VARCHAR(20) NOT NULL,
    begin_timestamp INT UNSIGNED NOT NULL,
    end_timestamp INT UNSIGNED NOT NULL DEFAULT 0,
    break TINYINT NOT NULL DEFAULT 0,
    delta SMALLINT NOT NULL DEFAULT 0,

    CONSTRAINT unique_days UNIQUE (employer_id, employer_working_time_id, mode, date),
    CONSTRAINT fk_employer FOREIGN KEY (employer_id) REFERENCES employer (id),
    CONSTRAINT fk_employer_working_times FOREIGN KEY (employer_working_time_id) REFERENCES employer_working_time (id),
    INDEX idx_working_times (employer_id, date, mode)
);