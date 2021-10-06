CREATE TABLE Role (
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	name TEXT NOT NULL
);

CREATE TABLE User (
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	name TEXT NOT NULL,
	password TEXT,
	email TEXT,
	isValid boolean,
	roleId INTEGER,
	FOREIGN KEY(roleId) REFERENCES Role(id)
);

CREATE TABLE Message (
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	name TEXT NOT NULL,
	dateReceipt TEXT,
	sender INTEGER,
	recipient INTEGER,
	subject Text,
	body Text
);
-- https://www.sqlite.org/foreignkeys.html