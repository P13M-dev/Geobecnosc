<?php


if(!isset($_POST["token"])) die;

$db = Database::get();
$db->query("UPDATE uczniowie SET zweryfikowany = FALSE , godzina_loginu = '1000-01-01 00:00:00' , token = '' WHERE token = ?",[$_POST["token"]]);

?>