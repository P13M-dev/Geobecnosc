<?php 

session_start();

if(!isAdmin()) die;

$dzien = $_POST["daySelect"];
$klasa = $_POST["classSelect"];

$db = Database::get();
$result = 0;

for($i=0; $i<10; $i++){
    $query = "SELECT Uczen.Imie,Uczen.Nazwisko,
    ObecnoscNaLekcji.spozniony,ObecnoscNaLekcji.obecny 

    FROM ObecnoscNaLekcji

    INNER JOIN ObecnoscWDniu ON ObecnoscWDniu.id = ObecnoscNaLekcji.ObecnoscWDniu_id
    INNER JOIN Uczen ON Uczen.Id = ObecnoscWDniu.Uczen_Id
    INNER JOIN Lekcja ON Lekcja.Godzina_idGodzina = ObecnoscNaLekcji.Lekcja_Godzina_idGodzina 

    WHERE ObecnoscWDniu_Uczen_Klasa_id = $klasa
    WHERE ObecnoscWDniu.Dzien_Dzien = $dzien
    WHERE ObecnoscNaLekcji_Lekcja_Godzina_idGodzina = $i";
    $result += $query;
}


echo json_encode($db->query($result));

?>