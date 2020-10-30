-- Users

INSERT INTO Users (jmeno, heslo, opravneni, email)
VALUES ('Alice Červená', '1234', 1, 'alice.cervena@email.cz');

INSERT INTO Users (jmeno, heslo, opravneni, email)
VALUES ('Bohumil Žlutý', '1234', 1, 'bohumil.zluty@email.cz');

INSERT INTO Users (jmeno, heslo, opravneni, email)
VALUES ('Claudie Růžová', '1234', 2, 'claudie.ruzova@email.cz');

INSERT INTO Users (jmeno, heslo, opravneni, email)
VALUES ('Dana Modrá', '1234', 2, 'dana.modra@email.cz');

INSERT INTO Users (jmeno, heslo, opravneni, email)
VALUES ('Eliška Zelená', '1234', 3, 'eliska.zelena@email.cz');

INSERT INTO Users (jmeno, heslo, opravneni, email)
VALUES ('Freya Černá', '1234', 3, 'freya.cerna@email.cz');

INSERT INTO Users (jmeno, heslo, opravneni, email)
VALUES ('Gabriela Hnědá', '1234', 4, 'gabriela.hneda@email.cz');

INSERT INTO Users (jmeno, heslo, opravneni, email)
VALUES ('Hana Bílá', '1234', 4, 'hana.bila@email.cz');

-- Clanky

INSERT INTO Clanky(autor, nazev, obsah)
VALUES (1, 'Zajimavy Clanek', 'Text clanku, Labore omnis adipisci saepe. Qui delectus deserunt dolores fugiat. Eos sed quo quia.
Quaerat ut sit eius. Eaque ratione autem eos et. Voluptates ut ea reiciendis quia voluptas impedit sint incidunt.
Qui perspiciatis omnis ut nam rem dignissimos cupiditate ea.');

INSERT INTO Clanky(autor, nazev, obsah)
VALUES (1, 'Kontroverzni Clanek', 'Text clanku, Labore omnis adipisci saepe. Qui delectus deserunt dolores fugiat. Eos sed quo quia.
Quaerat ut sit eius. Eaque ratione autem eos et. Voluptates ut ea reiciendis quia voluptas impedit sint incidunt.
Qui perspiciatis omnis ut nam rem dignissimos cupiditate ea.');

INSERT INTO Clanky(autor, nazev, obsah)
VALUES (2, 'Kvalitni clanek', 'Text clanku, Labore omnis adipisci saepe. Qui delectus deserunt dolores fugiat. Eos sed quo quia.
Quaerat ut sit eius. Eaque ratione autem eos et. Voluptates ut ea reiciendis quia voluptas impedit sint incidunt.
Qui perspiciatis omnis ut nam rem dignissimos cupiditate ea.');

-- Clanky_komentar

INSERT INTO Clanky_komentar(clanek, recenzent, komentar)
VALUES (1, 3, 'Toto je opravdu zajimavy clanek');

INSERT INTO Clanky_komentar(clanek, recenzent, komentar)
VALUES (1, 4, 'To neni zrovna zajimavy clanek');

INSERT INTO Clanky_komentar(clanek, recenzent, komentar)
VALUES (2, 3, 'Toto je opravdu kontroverzni clanek');

INSERT INTO Clanky_komentar(clanek, recenzent, komentar)
VALUES (2, 4, 'To neni zrovna kontroverzni clanek');

INSERT INTO Clanky_komentar(clanek, recenzent, komentar)
VALUES (3, 3, 'Toto je opravdu Kvalitni clanek');

INSERT INTO Clanky_komentar(clanek, recenzent, komentar)
VALUES (3, 4, 'To neni zrovna Kvalitni clanek');

-- Clanky_hodnoceni

INSERT INTO Clanky_hodnoceni(clanek, hodnotitel, aktualnost, originalita, odbornost, format)
VALUES (1, 3, 4, 4, 4, 4);

INSERT INTO Clanky_hodnoceni(clanek, hodnotitel, aktualnost, originalita, odbornost, format)
VALUES (1, 4, 5, 2, 1, 3);

INSERT INTO Clanky_hodnoceni(clanek, hodnotitel, aktualnost, originalita, odbornost, format)
VALUES (2, 3, 4, 4, 4, 4);

INSERT INTO Clanky_hodnoceni(clanek, hodnotitel, aktualnost, originalita, odbornost, format)
VALUES (2, 4, 5, 2, 1, 3);

INSERT INTO Clanky_hodnoceni(clanek, hodnotitel, aktualnost, originalita, odbornost, format)
VALUES (3, 3, 4, 4, 4, 4);

INSERT INTO Clanky_hodnoceni(clanek, hodnotitel, aktualnost, originalita, odbornost, format)
VALUES (3, 4, 5, 2, 1, 3);

-- Helpdesk_vlakno

INSERT INTO Helpdesk_vlakno(tazatel, predmet, obsah)
VALUES (1, 'Primitivni dotaz', 'Text dotazu, popis problemu. Lorem ipsum dolor sit amet? Proste to opravte/dodelejte.');

INSERT INTO Helpdesk_vlakno(tazatel, predmet, obsah)
VALUES (3, 'Dotaz', 'Text dotazu, popis problemu. Lorem ipsum dolor sit amet? Proste to opravte/dodelejte.');

INSERT INTO Helpdesk_vlakno(tazatel, predmet, obsah)
VALUES (5, 'Detailni dotaz', 'Text dotazu, popis problemu. Lorem ipsum dolor sit amet? Proste to opravte/dodelejte.');

-- Helpdesk_prispevek

INSERT INTO Helpdesk_prispevek(vlakno, uzivatel, obsah)
VALUES(1, 3, 'Odpoved na vlakno. Mozna se do reseni problemu jiz brzy pustime');

INSERT INTO Helpdesk_prispevek(vlakno, uzivatel, obsah)
VALUES(1, 8, 'Odpoved na vlakno. Mozna se do reseni problemu jiz brzy pustime');

INSERT INTO Helpdesk_prispevek(vlakno, uzivatel, obsah)
VALUES(2, 4, 'Odpoved na vlakno. Mozna se do reseni problemu jiz brzy pustime');

INSERT INTO Helpdesk_prispevek(vlakno, uzivatel, obsah)
VALUES(2, 6, 'Odpoved na vlakno. Mozna se do reseni problemu jiz brzy pustime');

INSERT INTO Helpdesk_prispevek(vlakno, uzivatel, obsah)
VALUES(3, 7, 'Odpoved na vlakno. Mozna se do reseni problemu jiz brzy pustime');

INSERT INTO Helpdesk_prispevek(vlakno, uzivatel, obsah)
VALUES(3, 8, 'Odpoved na vlakno. Mozna se do reseni problemu jiz brzy pustime');

-- Historie

INSERT INTO Historie(kdo, co) VALUES (1, 'Neco nezajimaveho');

INSERT INTO Historie(kdo, co) VALUES (3, 'Neco nezajimaveho');

INSERT INTO Historie(kdo, co) VALUES (4, 'Dulezita akce');

INSERT INTO Historie(kdo, co) VALUES (1, 'Neco nezajimaveho');

INSERT INTO Historie(kdo, co) VALUES (8, 'Vyznamna zmena');

INSERT INTO Historie(kdo, co) VALUES (3, 'Dulezita akce');

INSERT INTO Historie(kdo, co) VALUES (2, 'Dulezita akce');

INSERT INTO Historie(kdo, co) VALUES (6, 'Vyznamna zmena');

INSERT INTO Historie(kdo, co) VALUES (2, 'Neco nezajimaveho');

INSERT INTO Historie(kdo, co) VALUES (3, 'Vyznamna zmena');