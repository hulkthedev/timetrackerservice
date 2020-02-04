CREATE TABLE timetracking (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  date DATE NOT NULL,
  mode VARCHAR(20) NOT NULL,
  begin_timestamp INT NOT NULL,
  end_timestamp INT NOT NULL DEFAULT 0,
  delta INT NOT NULL DEFAULT 0,
  CONSTRAINT unique_days UNIQUE (date, mode)
) COLLATE = 'utf8_bin';

CREATE INDEX idx_timetracking
ON timetracking (date, mode);