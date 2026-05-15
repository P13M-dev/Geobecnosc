<?php 

session_start();

if(!isAdmin()) die;

$db = Database::get();

echo json_encode($db->query("SELECT id,nazwa FROM klasy"));

?>