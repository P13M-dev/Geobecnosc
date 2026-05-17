<?php
if(!isStudent()) die;

$db = Database::get();
$wynik = $db->query("SELECT godzina, dlugosc FROM godziny ORDER BY liczba_porzadkowa ASC");
$kod = "";
foreach($wynik as $row){
    $kod .= $row["godzina"]."λ".$row["dlugosc"]."Λ";
}
    
echo $kod;
?>