<?php

session_start();
if(!isAdmin()) die;
if(!isset($_POST["godziny"])) die;
$godziny = json_decode($_POST["godziny"],true);
$db = Database::get();
foreach($godziny as $godzina){
    $db->query("UPDATE godziny SET godzina = ? , dlugosc = ? WHERE liczba_porzadkowa = ?",[$godzina["godzina"],$godzina["dlugosc"],$godzina["liczba_porzadkowa"]]);
}
echo "ok";
?>