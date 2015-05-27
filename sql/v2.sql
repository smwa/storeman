CREATE TABLE itemimages(
  id int PRIMARY KEY AUTO_INCREMENT,
  itemid int,
  filename varchar(255),
  filedata mediumblob,
  INDEX (itemid)
);

CREATE TABLE containerimages(
  id int PRIMARY KEY AUTO_INCREMENT,
  containerid int,
  filename varchar(255),
  filedata mediumblob,
  INDEX (containerid)
);
