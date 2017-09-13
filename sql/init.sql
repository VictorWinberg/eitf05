-- Drop all tables if they exist

PRAGMA foreign_keys = OFF;
DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Items;
DROP TABLE IF EXISTS Orders;
PRAGMA foreign_keys = ON;

-- Create the tables --

CREATE TABLE Users (
	id				INTEGER NOT NULL,
	name			VARCHAR(255) NOT NULL,
	address			VARCHAR(255) NOT NULL,
	username		VARCHAR(255) NOT NULL,
	userPass		VARCHAR(255) NOT NULL,
	PRIMARY KEY		(id)
);

CREATE TABLE Items (
	id				INTEGER NOT NULL,
	name			TEXT NOT NULL DEFAULT (DATETIME('now')),
	price			FLOAT NOT NULL,
	PRIMARY KEY		(id)
);

CREATE TABLE Orders (
	id				INTEGER NOT NULL,
	timePlaced		TEXT NOT NULL DEFAULT (DATETIME('now')),
	userId			INTEGER NOT NULL,
	itemId			INTEGER NOT NULL,
	PRIMARY KEY		(id),
	FOREIGN KEY		(userId) REFERENCES Users(id),
	FOREIGN KEY		(itemId) REFERENCES Items(id)
);

-- Insert data into the tables --

INSERT INTO   	Users (name, address)
VALUES  		('Daniel Tovesson', 'Stora gatan 1, 12345 Lund', 'daniel', '123'),
				('Victor Winberg', 'Lilla gatan 2, 54321 Malmö', 'victor', '123'),
				('Oscar Rydh', 'Stora torget 3, 12311 Lomma', 'oscar', '123'),
		  		('Øverste', 'Lilla troget 4, 11123 Eslöv', 'hanna', '123');

INSERT INTO   	Items (name, price)
VALUES  		('Fidget spinner', 0.90),
		  		('Fidget spinner edition', 1999.9),
		  		('Mjölk', 10.79);

INSERT INTO   	Orders (timePlaced, userId, itemId)
VALUES  		('2017-08-02 10:11:22', 1, 2),
				('2017-08-02 10:11:22', 1, 3),
				('2017-08-12 15:23:45', 2, 2),
				('2017-08-12 15:23:47', 2, 2),
				('2017-09-01 00:11:03', 3, 3),
		  		('2017-09-12 12:34:11', 4, 1);
