USE trackingservice;
CREATE TABLE TimeTracking (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  date CHAR(100) NOT NULL,
  mode,
  begin VARCHAR(10000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  end CHAR(6) NOT NULL
);


CREATE INDEX idx_timetracking
ON TimeTracking (id, date);