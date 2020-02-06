CREATE TABLE employer (
    id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    working_hours_half TINYINT NOT NULL DEFAULT 6,
    working_break_half TINYINT NOT NULL DEFAULT 0,
    working_hours_full TINYINT NOT NULL DEFAULT 8,
    working_break_full TINYINT NOT NULL DEFAULT 30,
    working_hours_extreme TINYINT NULL,
    working_break_extreme TINYINT NULL,
    vacation_days TINYINT NOT NULL DEFAULT 30,

    CONSTRAINT unique_employer UNIQUE (name),
)
CHARACTER SET 'utf8mb4' COLLATE = 'utf8mb4_unicode_ci';

CREATE TABLE employer_config (
    id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    employer_id SMALLINT UNSIGNED NOT NULL,
    employer_color VARCHAR(7) NOT NULL DEFAULT '#000000',
    time_account BIT NOT NULL 1,

    CONSTRAINT fk_employer FOREIGN KEY (employer_id) REFERENCES employer (id)
        ON DELETE CASCADE
        ON UPDATE RESTRICT
)
CHARACTER SET 'utf8mb4' COLLATE = 'utf8mb4_unicode_ci';

CREATE TABLE timetracking (
    id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    employer_id SMALLINT UNSIGNED NOT NULL,
    date DATE NOT NULL,
    mode VARCHAR(20) NOT NULL,
    begin_timestamp INT UNSIGNED NOT NULL,
    end_timestamp INT UNSIGNED NOT NULL DEFAULT 0,
    delta SMALLINT UNSIGNED NOT NULL DEFAULT 0,

    CONSTRAINT unique_days UNIQUE (date, employer_id, mode),
    CONSTRAINT fk_employer FOREIGN KEY (employer_id) REFERENCES employer (id)
        ON DELETE CASCADE
        ON UPDATE RESTRICT
)
CHARACTER SET 'utf8mb4' COLLATE = 'utf8mb4_unicode_ci';

CREATE INDEX idx_timetracking
ON timetracking (employer_id, date, mode);