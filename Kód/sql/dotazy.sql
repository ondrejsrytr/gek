-- Vypsání všech údajů daného uživatele 
SELECT jmeno, prijmeni, email
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
SELECT obsah, predmet, tazatel, jmeno, prijmeni
FROM Helpdesk_vlakno
JOIN Users ON tazatel = Users.id;


-- Vypsat Recenzenta, který hodnotil článek od uživatele X
SELECT jmeno, prijmeni, email FROM Users
JOIN Clanky_hodnoceni ON Clanky_hodnoceni.hodnotitel = Users.id
JOIN Clanky ON Clanky_hodnoceni.clanek = Clanky.id
WHERE Clanky.autor = ?;

-- Vypsat všechny články a seřadit je podle datumu vydání (od nejnovějších po nejstarší)
SELECT autor, nazev, obsah, datum_vydani
FROM Clanky
ORDER BY datum_vydani DESC;

-- Vypsat všechny změny z tabulky Historie, kde je jsou změny provedeny od uživatele X
SELECT jmeno, prijmeni, co, datum
FROM Historie
JOIN Users ON kdo = Users.id
WHERE Users.id = ?;

--Vypsat všechny změny z tabulky Historie, které provedl uživatel X v datum Y

SELECT jmeno, prijmeni, co, datum
FROM Historie
JOIN Users ON kdo = Users.id
WHERE Users.id = ?
AND datum = ?;