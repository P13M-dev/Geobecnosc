<?php 

session_start();

if(!isset($_POST["email"])) die;
if(!isset($_POST["haslo"])) die;
$db = Database::get();

$wynik = $db->query("SELECT id,hash_hasla,administrator FROM nauczyciele WHERE email = ?",[$_POST["email"]]);
if(sizeof($wynik)==0) die; 
if(!password_verify($_POST["haslo"],$wynik[0]["hash_hasla"])) die;
$_SESSION["idNauczyciela"] = $wynik[0]["id"];
$_SESSION["pozycja"] = $wynik[0]["administrator"] ? 2 : 1;

echo "ok";

?>

