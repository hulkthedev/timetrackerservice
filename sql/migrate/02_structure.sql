USE basket;
CREATE TABLE Config (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  const CHAR(100) NOT NULL,
  value VARCHAR(10000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  locale CHAR(6) NOT NULL
);

CREATE UNIQUE INDEX idx_config
ON Config (const, locale);