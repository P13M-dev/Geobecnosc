<?php 

session_start();

if(!isset($_POST["email"])) die;
if(!isset($_POST["haslo"])) die;
$db = Database::get();

$wynik = $db->query("SELECT id,imie,nazwisko,hash_hasla,administrator FROM nauczyciele WHERE email=?",[$_POST["email"]]);
if(sizeof($wynik)==0) {echo "incorrect";die;} 
if(!password_verify($_POST["haslo"],$wynik[0]["hash_hasla"])) {echo "incorrect";die;} 
$_SESSION["idNauczyciela"] = $wynik[0]["id"];
$_SESSION["imie"] = $wynik[0]["imie"];
$_SESSION["nazwisko"] = $wynik[0]["nazwisko"];
$_SESSION["pozycja"] = $wynik[0]["administrator"] ? 2 : 1;

echo $wynik[0]["administrator"] ? "admin" : "nauczyciel";

?>

