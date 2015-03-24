CREATE TABLE companies(
  company_id INT UNSIGNED NOT NULL,
  name VARCHAR(100) NOT NULL,
  created DATETIME NOT NULL,
  modified TIMESTAMP,

  PRIMARY KEY (company_id)
) Engine=InnoDB;


CREATE TABLE users(
  user_id INT UNSIGNED NOT NULL,
  email VARCHAR(100) NOT NULL,
  password VARCHAR(100) NOT NULL,
  company_id INT UNSIGNED NOT NULL,
  created DATETIME NOT NULL,
  modified TIMESTAMP,

  PRIMARY KEY (user_id),
  FOREIGN KEY (company_id) REFERENCES companies(company_id) ON DELETE CASCADE ON UPDATE CASCADE
) Engine=InnoDB;


CREATE TABLE grow(
  grow_id INT UNSIGNED NOT NULL,
  company_id INT UNSIGNED NOT NULL,
  user_id INT UNSIGNED NOT NULL,
  created DATETIME NOT NULL,
  modified TIMESTAMP,

  PRIMARY KEY (grow_id),
  FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (company_id) REFERENCES companies(company_id) ON DELETE CASCADE ON UPDATE CASCADE
) Engine=InnoDB;


CREATE TABLE plant_types(
  type_id INT UNSIGNED NOT NULL,
  name VARCHAR(100) NOT NULL,
  created DATETIME NOT NULL,
  modified TIMESTAMP,
  PRIMARY KEY (type_id)
) ENGINE=InnoDB;

CREATE TABLE plant(
  plant_id INT UNSIGNED NOT NULL,
  grow_id INT UNSIGNED NOT NULL,

  name VARCHAR(100) NOT NULL,
  type_id INT UNSIGNED DEFAULT NULL,

  created DATETIME NOT NULL,
  modified TIMESTAMP,

  PRIMARY KEY (plant_id),
  FOREIGN KEY (grow_id) REFERENCES grow(grow_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (type_id) REFERENCES plant_types(type_id) ON DELETE SET NULL ON UPDATE CASCADE
) Engine=InnoDB;