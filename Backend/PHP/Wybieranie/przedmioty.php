<?php 

session_start();

if(!isAdmin()) die;

$db = Database::get();
$db->query("SELECT id,nazwa FROM ");



?>