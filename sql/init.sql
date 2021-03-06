-- Drop all tables if they exist

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Items;
DROP TABLE IF EXISTS Orders;
DROP TABLE IF EXISTS Reviews;
SET FOREIGN_KEY_CHECKS = 1;

-- Create the tables --

CREATE TABLE Users (
	id				INTEGER NOT NULL AUTO_INCREMENT,
	name			VARCHAR(255) NOT NULL,
	address			VARCHAR(255) NOT NULL,
	username		VARCHAR(255) NOT NULL UNIQUE,
	hash			VARCHAR(255) NOT NULL,
	attempts		INT DEFAULT 0,
	attemptTime		TIMESTAMP DEFAULT NULL,
	PRIMARY KEY		(id)
);

CREATE TABLE Items (
  id          INTEGER NOT NULL AUTO_INCREMENT,
  name        VARCHAR(255) NOT NULL UNIQUE,
  price       FLOAT NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE Orders (
  id          INTEGER NOT NULL AUTO_INCREMENT,
  timePlaced  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  userId      INTEGER NOT NULL,
  itemId      INTEGER NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (userId) REFERENCES Users(id),
  FOREIGN KEY (itemId) REFERENCES Items(id)
);
CREATE TABLE Reviews (
  id          INTEGER NOT NULL AUTO_INCREMENT,
  name        VARCHAR(255) NOT NULL,
  subject     VARCHAR(255) NOT NULL,
  review      VARCHAR(255) NOT NULL,
  ts          TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
);

-- Insert data into the tables --

INSERT INTO Users (name, address, username, hash)
VALUES ('Daniel Tovesson', 'Stora gatan 1, 12345 Lund', 'daniel', '$2y$10$CHbI37mESYuZgBOzd0UCi.nIF1iuJRqlSPk/DHaOnv/JIYNOtGfhW'),
       ('Victor Winberg', 'Lilla gatan 2, 54321 Malmö', 'victor', '$2y$10$SQYRwALmfsjSe/W1jO8zaeAV69ziiY7m7i4G0JyJwQbQsHSb1NOKC'),
       ('Oscar Rydh', 'Stora torget 3, 12311 Lomma', 'oscar', '$2y$10$9dAXYvgCdlPo0QfyGQqHFODu1d.b.VT2Is28DcJXPubaNAh.JyfGW'),
       ('Øverste', 'Lilla torget 4, 11123 Eslöv', 'hanna', '$2y$10$S284DWkRDd9EGax8Op2Rgu7zXMruaZNxxtdvk9xisWPZusHB2uz7O');

INSERT INTO Items (name, price)
VALUES ('Fidget spinner', 0.90),
       ('Fidget spinner edition', 1999.9),
       ('Milk', 10.79);

INSERT INTO Orders (timePlaced, userId, itemId)
VALUES ('2017-08-02 10:11:22', 1, 2),
       ('2017-08-02 10:11:22', 1, 3),
       ('2017-08-12 15:23:45', 2, 2),
       ('2017-08-12 15:23:47', 2, 2),
       ('2017-09-01 00:11:03', 2, 3),
       ('2017-09-12 12:34:11', 3, 1);

INSERT INTO Reviews (name, subject, review)
VALUES ('Hanna Lindwall', '10/10', 'This is a great site!'),
       ('Victor Winberg', 'Could be better', 'The webshop has a good selection of products but lacks atmophere.'),
       ('H4ck3rAn2n', 'Design is awful!', '&lt;span style=&quot;color:red&quot;&gt;My webshop has a much C00L3R design that your shop!&lt;/span&gt;');
