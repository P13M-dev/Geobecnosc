<?php

session_start();
if(!isAdmin()) die;
if(!isset($_POST["data"])) die;
if(!isset($_POST["klasa"])) die;
$db = Database::get();
$data = $_POST["data"];
$klasa = $_POST["klasa"];
$dzien = $db->query(
"SELECT p.nazwa,g.liczba_porzadkowa FROM lekcje as l 
INNER JOIN przedmioty as p ON p.id = l.przedmiot
INNER JOIN godziny as g ON g.id = l.godzina
");

echo json_encode($dzien);
?>