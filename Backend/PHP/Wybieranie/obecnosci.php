<?php 

session_start();

if(!isAdmin()) die;
if(!isset($_POST["dzien"])) die;
if(!isset($_POST["klasa"])) die;

$db = Database::get();
$dzien = $db->query("SELECT id FROM dni WHERE dzien = ?",[$_POST["dzien"]]);
if(sizeof($dzien)==0) die;
$dzien = $dzien[0]["id"];
$obecnosci = $db->query(
    "   SELECT u.imie,u.nazwisko,ol.spozniony,ol.obecny,g.liczba_porzadkowa FROM obecnosci_na_lekcji as ol
        INNER JOIN lekcje as l ON l.id = ol.lekcja 
        INNER JOIN godziny as g ON g.id = l.godzina
        INNER JOIN obecnosci_w_dniu as od ON od.id = ol.obecnosc
        INNER JOIN uczniowie as u ON u.id = od.uczen
        WHERE od.dzien = ? AND u.klasa = ?
    ",[$dzien,$_POST["klasa"]]
);

echo json_encode($obecnosci);

?>