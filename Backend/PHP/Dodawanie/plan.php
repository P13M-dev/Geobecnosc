<?php

session_start();
if(!isAdmin()) die;
if(!isset($_POST["plan"])) die;
if(!isset($_POST["klasa"])) die;
$plan = json_decode($_POST["plan"],true);
$db = Database::get();
$wynik = $db->query("SELECT COUNT(l.id) as istnieje FROM lekcje WHERE dzien = ?",[$plan[0]["data"]]);
$klasa = $_POST["klasa"];

if($wynik[0]["istnieje"]){ // nadpisz lekcje
    foreach($plan as $dzien){
        foreach($dzien["lekcje"] as $lekcja){
            $db->query("UPDATE lekcje SET przedmiot = ? WHERE godzina = ? AND dzien = ? AND klasa = ?",[$lekcja["przedmiot"],$lekcja["godzina"],$dzien["data"],$klasa]);
            
        }
    }
} else { // zapisz lekcje
    $uczniowie = $db->query("SELECT id FROM uczniowie WHERE klasa = ?",[$klasa]);
    foreach($plan as $dzien){
        foreach($dzien["lekcje"] as $lekcja){
            $db->query("INSERT INTO lekcje (godzina,dzien,przedmiot,klasa) VALUES (?,?,?,?)",[$lekcja["godzina"],$dzien["data"],$lekcja["przedmiot"],$klasa]);
            $id_lekcji = $db->query("SELECT id FROM lekcje WHERE godzina = ? AND dzien = ? AND klasa = ?",[$lekcja["godzina"],$dzien["data"],$klasa])[0]["id"];
            foreach($uczniowie as $uczen){
                $db->query("INSERT INTO obecnosci_na_lekcji (lekcja,uczen) VALUES (?,?)",[$id_lekcji,$uczen]);
            }
        }
    }
}

echo "ok";
?>