<?php

session_start();
// if(!isAdmin()) die;
if(!isset($_POST["przedmiot"])) die;

$db = Database::get();
$db->query("INSERT INTO przedmioty (nazwa) VALUES (?)",[$_POST["przedmiot"]]); 
echo "ok";

?>