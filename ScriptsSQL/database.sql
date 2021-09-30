CREATE TABLE Role (
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	name TEXT NOT NULL
);

CREATE TABLE User (
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	name TEXT NOT NULL,
	password TEXT
	isValid boolean,
	roleId INTEGER,
	FOREIGN KEY(roleId) REFERENCES Role(id)
);

CREATE TABLE Message (
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	name TEXT NOT NULL,
	dateReceipt TEXT,
	sender INTEGER,
	recipient INTEGER,
	subjectd Text,
	body Text
);
-- https://www.sqlite.org/foreignkeys.html