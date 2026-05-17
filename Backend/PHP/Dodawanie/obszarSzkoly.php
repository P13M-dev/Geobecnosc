<?php

session_start();

if(!isAdmin()) die;
if(!isset($_POST["obszar"])) die;

$db = Database::get();

$db->query("UPDATE dane_szkoly SET obszar_szkoly = ? WHERE id = 1",[$_POST["obszar"]]);
echo "ok";

?>