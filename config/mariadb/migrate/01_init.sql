CREATE TABLE timetracking (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  date DATE NOT NULL,
  mode CHAR(20) NOT NULL,
  begin TIMESTAMP NOT NULL,
  end TIMESTAMP NOT NULL
);

CREATE INDEX idx_timetracking
ON timetracking (id, date, mode);