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

INSERT INTO user (name, password, email, isValid, idRole) VALUES ('admin', '$2y$10$oHl81e3kQwezb46dFiE3auxB5cwKtgo7dSfJC24/spL/UxfBETNE6', 'admin@admin.ch', 1, 1)
INSERT INTO user (name, password, email, isValid, idRole) VALUES ('user', '$2y$10$ynfm1wikH8p8XuixC0hlueuIcwhUBBcgEVx89U8keaPvVU011tv6u', 'user@user.ch', 1, 2)
