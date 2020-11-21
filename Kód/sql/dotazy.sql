-- Vypsání všech údajů daného uživatele 
SELECT jmeno, email
FROM Users
WHERE id=?;

-- Vypsání všech článků (název, autor, datum)
SELECT autor, nazev, obsah, datum_vydani 
FROM Clanky;

-- Vyhledání článku podle názvu
SELECT autor, nazev, obsah, datum_vydani
FROM Clanky
WHERE nazev LIKE ?;

-- Vypsání všech vláken z helpdesk_vlákno (Předmět, Datum, Uživatel)
SELECT obsah, predmet, tazatel, jmeno
FROM Helpdesk_vlakno
JOIN Users ON tazatel = Users.id;


-- Vypsat Recenzenta, který hodnotil článek od uživatele X
SELECT Users.id, jmeno, email
FROM Users
JOIN Clanky_hodnoceni ON Clanky_hodnoceni.hodnotitel = Users.id
JOIN Clanky ON Clanky_hodnoceni.clanek = Clanky.id
WHERE Clanky.autor = ?;

-- Vypsat všechny články a seřadit je podle datumu vydání (od nejnovějších po nejstarší)
SELECT autor, nazev, datum_vydani
FROM Clanky
ORDER BY datum_vydani DESC;

-- Vypsat všechny změny z tabulky Historie, kde je jsou změny provedeny od uživatele X
SELECT jmeno, co, datum
FROM Historie
JOIN Users ON kdo = Users.id
WHERE kdo = ?;

--Vypsat všechny změny z tabulky Historie, které provedl uživatel X v datum Y

SELECT jmeno, co, datum
FROM Historie
JOIN Users ON kdo = Users.id
WHERE Users.id = ?
AND datum LIKE ?;

--Vypsat všechny články a jejich autory jako jméno
SELECT Users.jmeno, Clanky.nazev, Clanky.datum_vydani 
FROM Clanky INNER 
JOIN Users 
on Clanky.autor = Users.id;

-- Vypsat hodnocení článků od daného uživatele
SELECT Clanky.nazev, B.jmeno as hodnotitel, datum_ohodnoceni, aktualnost, originalita, odbornost, format
FROM Clanky_hodnoceni
JOIN Clanky ON Clanky_hodnoceni.clanek = Clanky.id
JOIN Users B ON Clanky_hodnoceni.hodnotitel = B.id
WHERE Clanky.autor = ?;
