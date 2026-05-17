<?php 

session_start();

// if(!isAdmin()) die;
if(!isset($_POST["imie"])) die;
if(!isset($_POST["nazwisko"])) die;
if(!isset($_POST["email"])) die;
if(!isset($_POST["haslo"])) die;
if(!isset($_POST["przedmiot"])) die;

$db = Database::get();
$hash = password_hash($_POST["haslo"],PASSWORD_DEFAULT);
$db->query("INSERT INTO nauczyciele (imie,nazwisko,email,hash_hasla,przedmiot,administrator) VALUES (?,?,?,?,?,FALSE)",[
    $_POST["imie"],
    $_POST["nazwisko"],
    $_POST["email"],
    $hash,
    $_POST["przedmiot"]
]); 

echo "ok";

?>
