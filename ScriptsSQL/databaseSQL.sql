CREATE TABLE role (
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	name TEXT NOT NULL
);

CREATE TABLE user (
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	name TEXT NOT NULL,
	password TEXT,
	email TEXT,
	isValid boolean,
	idRole INTEGER,
	FOREIGN KEY(idRole) REFERENCES Role(id)
);

CREATE TABLE message (
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	dateReceipt TEXT,
	sender INTEGER,
	recipient INTEGER,
	subject Text,
	body Text
);
-- https://www.sqlite.org/foreignkeys.html

INSERT INTO role (name) VALUES ('Utilisateur');
INSERT INTO role (name) VALUES ('Administrateur');
