#Database config
CREATE TABLE config (
  id int(11) PRIMARY KEY AUTO_INCREMENT,
  database_version int(11) NOT NULL DEFAULT 0
);

INSERT INTO config (database_version) VALUES (1);

#User tables
CREATE TABLE users (
  id int(11) PRIMARY KEY AUTO_INCREMENT,
  email varchar(255),
  password varchar(128),
  INDEX (email)
);

CREATE TABLE sessions (
  id int(11) PRIMARY KEY AUTO_INCREMENT,
  sessionid varchar(128),
  userid int(11),
  lastactiontime datetime,
  INDEX (sessionid),
  INDEX (lastactiontime)
);

#Problem Specific
CREATE TABLE locations (
  id int(11) PRIMARY KEY AUTO_INCREMENT,
  userid int(11),
  title VARCHAR(255),
  description VARCHAR(255),
  INDEX (userid)
);

CREATE TABLE containers (
  id int(11) PRIMARY KEY AUTO_INCREMENT,
  userid int(11),
  locationid INT(11),
  title VARCHAR(255),
  INDEX (userid)
);

CREATE TABLE items (
  id int(11) PRIMARY KEY AUTO_INCREMENT,
  userid int(11),
  locationid INT(11),
  containerid INT(11),
  title VARCHAR(255),
  INDEX (userid)
);
