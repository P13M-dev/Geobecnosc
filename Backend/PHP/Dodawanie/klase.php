<?php

session_start();

if(!isAdmin()) die;
if(!isset($_POST["klasa"])) die;

$db = Database::get();
$db->query("INSERT INTO klasy (nazwa) VALUES (?)",[$_POST["klasa"]]); 
echo "success";

?>