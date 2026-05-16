<?php


if(!isset($_POST["email"])) die;
if(!isset($_POST["haslo"])) die;

$db = Database::get();
$uczen = $db->query("SELECT id,hash_hasla,godzina_loginu,token,zweryfikowany FROM uczniowie WHERE email = ?",[$_POST["email"]]);

if(sizeof($uczen)==0) die;
$uczen = $uczen[0];
if(!password_verify($_POST["haslo"],$uczen["hash_hasla"])) die;

if($uczen["godzina_loginu"]=="1000-01-01 00:00:00"){ // uczen nie zaczął procesu logowania
    $token = $randomString = bin2hex(random_bytes(32)); 
    $data = new DateTime();
    $db->query("UPDATE uczniowie SET zweryfikowany = FALSE , token = ? , godzina_loginu = ? WHERE id = ?",[$token,$data->format("Y-m-d H:i:s"),$uczen["id"]]);

} else {
    if(!isset($_POST["token"])) die;
    if($_POST["token"]!=$uczen["token"]) die;
    $data = new DateTime($uczen["godzina_loginu"]);
    $stara = new DateTime('-24 hours');
    if($data > $stara) die; // login jest młodszy niż 24 godziny
    $token = $randomString = bin2hex(random_bytes(32)); 
    $db->query("UPDATE uczniowie SET zweryfikowany = TRUE , token = ? WHERE id = ?",[$token,$uczen["id"]]);
    echo $token;
}

?>