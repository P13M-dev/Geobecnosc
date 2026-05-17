<?php 

session_start();

if(!isAdmin()) die;
if(!isset($_POST["dzien"])) die;
if(!isset($_POST["klasa"])) die;

$db = Database::get();
$obecnosci = $db->query(
    "   SELECT l.dzien ,u.imie , u.nazwisko, JSON_ARRAYAGG(JSON_ARRAY(g.godzina, o.obecny, o.spozniony)) AS obecnosci FROM lekcje as l
        INNER JOIN godziny as g ON g.id = l.godzina
        INNER JOIN obecnosci_na_lekcji as o ON l.id = o.lekcja 
        INNER JOIN uczniowie as u ON u.id = o.uczen
        WHERE l.dzien = ? AND l.klasa = ?
        GROUP BY u.id
        ORDER BY u.nazwisko, u.imie ASC
    ",[$_POST["dzien"],$_POST["klasa"]]
);

echo json_encode($obecnosci);

?>