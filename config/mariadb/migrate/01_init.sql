CREATE TABLE timetracking (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  date DATE NOT NULL,
  mode VARCHAR(20) NOT NULL,
  begin_timestamp INT NOT NULL,
  end_timestamp INT NOT NULL,
  delta INT NOT NULL,
  CONSTRAINT unique_days UNIQUE (date, mode)
);

CREATE INDEX idx_timetracking
ON timetracking (date, mode);