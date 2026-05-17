<?php 

session_start();
if(!isAdmin())die;
$db = Database::get();
$wynik = $db->query("SELECT liczba_porzadkowa,godzina,dlugosc FROM godziny ORDER BY liczba_porzadkowa ASC");
echo json_encode($wynik);

?>