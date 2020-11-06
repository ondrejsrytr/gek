CREATE TABLE Users(
	id SERIAL PRIMARY KEY,
	jmeno VARCHAR(60),
	heslo TEXT,
	opravneni INT DEFAULT 0,
	email VARCHAR(60)
);

CREATE TABLE Tokeny (
	id SERIAL PRIMARY KEY,
	token VARCHAR(24) NOT NULL,
	uzivatel INT REFERENCES Users(id),
	ucel INT
);

CREATE TABLE Clanky(
	id SERIAL PRIMARY KEY,
	autor INT REFERENCES Users(id),
	nazev TEXT,
	obsah TEXT,
	datum_vydani TIMESTAMP DEFAULT Now()
);

CREATE TABLE Clanky_komentar (
	id SERIAL PRIMARY KEY,
	clanek INT REFERENCES Clanky(id),
	recenzent INT REFERENCES Users(id),
	komentar TEXT,
	datum TIMESTAMP DEFAULT Now()
);

CREATE TABLE Clanky_hodnoceni (
	id SERIAL PRIMARY KEY,
	clanek INT REFERENCES Clanky(id),
	hodnotitel INT REFERENCES Users(id),
	datum_ohodnoceni TIMESTAMP DEFAULT Now(),
	aktualnost INT CHECK (aktualnost >= 1 AND aktualnost <= 5),
	originalita INT CHECK (originalita >= 1 AND originalita <= 5),
	odbornost INT CHECK (odbornost >= 1 AND odbornost <= 5),
	format INT CHECK (format >= 1 AND format <= 5)
);

CREATE TABLE Helpdesk_vlakno (
	id SERIAL PRIMARY KEY,
	predmet TEXT,
	obsah TEXT,
	tazatel INT REFERENCES Users(id),
	datum TIMESTAMP DEFAULT Now(),
	stav BOOLEAN DEFAULT FALSE
);

CREATE TABLE Helpdesk_prispevek (
	id SERIAL PRIMARY KEY,
	vlakno INT REFERENCES Helpdesk_vlakno(id),
	uzivatel INT REFERENCES Users(id),
	datum TIMESTAMP DEFAULT Now(),
	obsah TEXT
);

CREATE TABLE Historie (
	id SERIAL PRIMARY KEY,
	kdo INT REFERENCES Users(id),
	co TEXT,
	datum TIMESTAMP DEFAULT Now()
);

-- smazani tabulek
/*
DROP TABLE Users, Clanky, Clanky_komentar, Clanky_hodnoceni, Helpdesk_vlakno, Helpdesk_prispevek, Historie;
*/