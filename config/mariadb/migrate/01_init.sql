CREATE TABLE employer (
    id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    working_hours_half TINYINT UNSIGNED NOT NULL DEFAULT 6,
    working_break_half TINYINT UNSIGNED NOT NULL DEFAULT 0,
    working_hours_full TINYINT UNSIGNED NOT NULL DEFAULT 8,
    working_break_full TINYINT UNSIGNED NOT NULL DEFAULT 30,
    working_hours_extreme TINYINT UNSIGNED NULL,
    working_break_extreme TINYINT UNSIGNED NULL,
    vacation_days TINYINT UNSIGNED NOT NULL DEFAULT 30,

    CONSTRAINT unique_employer UNIQUE (name)
)
CHARACTER SET 'utf8mb4' COLLATE = 'utf8mb4_unicode_ci';

CREATE TABLE employer_config (
    id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    employer_id SMALLINT UNSIGNED NOT NULL,
    frontend_color VARCHAR(7) NOT NULL DEFAULT '#000000',

    CONSTRAINT unique_employer UNIQUE (employer_id),
    CONSTRAINT fk_employer FOREIGN KEY (employer_id) REFERENCES employer (id)
        ON DELETE CASCADE
        ON UPDATE RESTRICT
)
CHARACTER SET 'utf8mb4' COLLATE = 'utf8mb4_unicode_ci';

CREATE TABLE time_account (
    id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    employer_id SMALLINT UNSIGNED NULL,
    enabled BIT NOT NULL DEFAULT  1,
    time SMALLINT NULL DEFAULT 0,

    CONSTRAINT unique_employer UNIQUE (employer_id),
    CONSTRAINT fk_employer FOREIGN KEY (employer_id) REFERENCES employer (id)
        ON DELETE CASCADE
        ON UPDATE RESTRICT
)
CHARACTER SET 'utf8mb4' COLLATE = 'utf8mb4_unicode_ci';

CREATE TABLE working_times (
    id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    employer_id SMALLINT UNSIGNED NOT NULL,
    date DATE NOT NULL,
    mode VARCHAR(20) NOT NULL,
    begin_timestamp INT UNSIGNED NOT NULL,
    end_timestamp INT UNSIGNED NOT NULL DEFAULT 0,
    delta SMALLINT NOT NULL DEFAULT 0,

    CONSTRAINT unique_days UNIQUE (date, employer_id, mode),
    CONSTRAINT fk_employer FOREIGN KEY (employer_id) REFERENCES employer (id)
        ON DELETE CASCADE
        ON UPDATE RESTRICT
)
CHARACTER SET 'utf8mb4' COLLATE = 'utf8mb4_unicode_ci';

CREATE INDEX idx_timetracking
ON timetracking (employer_id, date, mode);