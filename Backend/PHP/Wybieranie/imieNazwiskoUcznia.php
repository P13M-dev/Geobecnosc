<?php 

if(!isStudent()) die;

$db = Database::get();
$uczen = $db->query("SELECT u.imie,u.nazwisko,k.nazwa FROM uczniowie as u INNER JOIN klasy as k ON u.klasa = k.id WHERE token = ?",[$_POST["token"]]);

if(sizeof($uczen)==0) die;

$uczen = $uczen[0];

echo $uczen["imie"]."λ".$uczen["nazwisko"]."λ".$uczen["nazwa"];

?>