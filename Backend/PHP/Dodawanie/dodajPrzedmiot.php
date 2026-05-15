<?php

require_once "api.php";

session_start();

if(!isAdmin()) die;
if(!isset($_POST["przedmiot"])) die;

$db = Database::get();
$db->query("INSERT INTO przedmiot (nazwa) VALUES (?)",[$_POST["przedmiot"]]); 
echo "success";

?>