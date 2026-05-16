<?php 


if(!isStudent()) die;

$db = Database::get();
$uczen = $db->query("SELECT imie,nazwisko FROM uczniowie WHERE token");

if(sizeof($uczen)==0) die;

$uczen = $uczen[0];
$dane = ["imie"=>$uczen["imie"],"nazwisko"=>$uczen["nazwisko"]];

return $dane;


?>