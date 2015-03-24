CREATE TABLE companies(
  company_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  created DATETIME NOT NULL,
  modified TIMESTAMP,

  PRIMARY KEY (company_id)
) Engine=InnoDB;


CREATE TABLE users(
  user_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  email VARCHAR(100) NOT NULL,
  password VARCHAR(100) NOT NULL,
  company_id INT UNSIGNED NOT NULL,
  created DATETIME NOT NULL,
  modified TIMESTAMP,

  PRIMARY KEY (user_id),
  FOREIGN KEY (company_id) REFERENCES companies(company_id) ON DELETE CASCADE ON UPDATE CASCADE
) Engine=InnoDB;

CREATE TABLE grow_status(
  status_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,

  created DATETIME NOT NULL,
  modified TIMESTAMP,

  PRIMARY KEY (status_id),
  KEY(name)
) Engine=InnoDB;

INSERT INTO grow_status(status_id, name, created) VALUES(1, 'planning', NOW()),(2, 'planted',NOW()),(3, 'vegetation',NOW()),(4, 'flowering',NOW()),(5, 'checking',NOW()),(6, 'done',NOW()),(7, 'canceled',NOW());

CREATE TABLE grow(
  grow_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  company_id INT UNSIGNED NOT NULL,
  user_id INT UNSIGNED NOT NULL,
  status_id INT UNSIGNED DEFAULT 1,

  created DATETIME NOT NULL,
  modified TIMESTAMP,

  PRIMARY KEY (grow_id),
  KEY(status),
  FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (company_id) REFERENCES companies(company_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (status_id) REFERENCES grow_status(status_id) ON DELETE SET NULL ON UPDATE CASCADE
) Engine=InnoDB;


CREATE TABLE plant_types(
  type_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  created DATETIME NOT NULL,
  modified TIMESTAMP,
  PRIMARY KEY (type_id)
) ENGINE=InnoDB;

CREATE TABLE plant(
  plant_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  grow_id INT UNSIGNED NOT NULL,

  name VARCHAR(100) NOT NULL,
  type_id INT UNSIGNED DEFAULT NULL,

  status_id INT UNSIGNED DEFAULT NULL,

  planted_on DATETIME DEFAULT NULL,
  vegetation_on DATETIME DEFAULT NULL,
  flowering_on DATETIME DEFAULT NULL,
  chop_chop_on DATETIME DEFAULT NULL,

  created DATETIME NOT NULL,
  modified TIMESTAMP,

  PRIMARY KEY (plant_id),
  FOREIGN KEY (grow_id) REFERENCES grow(grow_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (type_id) REFERENCES plant_types(type_id) ON DELETE SET NULL ON UPDATE CASCADE,
  FOREIGN KEY (status_id) REFERENCES grow_status(status_id) ON DELETE SET NULL ON UPDATE CASCADE
) Engine=InnoDB;