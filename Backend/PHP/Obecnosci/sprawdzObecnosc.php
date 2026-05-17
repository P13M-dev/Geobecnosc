<?php
if(!isStudent()) die;

if(!isset($_POST["pozycja"])) die;
if(!isset($_POST["nr_lekcji"])) die;
if(!isset($_POST["spoznienie"])) die;


if($_POST["nr_lekcji"]>10) die;

$db = Database::get();
$obszarSzkoly = $db->query(
   "SELECT obszar_szkoly FROM dane_szkoly
    WHERE id = 1;"
);
$pozycja = json_decode($_POST["pozycja"], true);
$obszarSzkoly = json_decode($obszarSzkoly[0]["obszar_szkoly"], true);

function checkIfInsidePolygon(array $polygon, array $point): bool {

    $n = count($polygon);

    if ($n < 3) {
        return false;
    }

    $px = $point['lng'];
    $py = $point['lat'];

    $inside = false;

    for ($i = 0, $j = $n - 1; $i < $n; $j = $i++) {

        $xi = $polygon[$i]['lng'];
        $yi = $polygon[$i]['lat'];

        $xj = $polygon[$j]['lng'];
        $yj = $polygon[$j]['lat'];

        // point on edge
        if (pointOnSegment($px, $py, $xi, $yi, $xj, $yj)) {
            return true;
        }

        $intersect =
            (($yi > $py) != ($yj > $py))
            &&
            ($px < ($xj - $xi) * ($py - $yi) / ($yj - $yi) + $xi);

        if ($intersect) {
            $inside = !$inside;
        }
    }

    return $inside;
}

function pointOnSegment(float $px, float $py, float $x1, float $y1, float $x2, float $y2, float $eps = 0.000000001): bool {

    $cross =
        ($px - $x1) * ($y2 - $y1)
        -
        ($py - $y1) * ($x2 - $x1);

    if (abs($cross) > $eps) {
        return false;
    }

    $dot =
        ($px - $x1) * ($x2 - $x1)
        +
        ($py - $y1) * ($y2 - $y1);

    if ($dot < 0) {
        return false;
    }

    $lenSq =
        ($x2 - $x1) * ($x2 - $x1)
        +
        ($y2 - $y1) * ($y2 - $y1);

    return $dot <= $lenSq;
}

$obecnosc = true;
$dzien = "2026-05-18";
if(!checkIfInsidePolygon($obszarSzkoly,$pozycja)) $obecnosc = false; // poza obszarem
$spoznienie = $_POST["spoznienie"]; 

$czyObecny = $db->query("SELECT obecny FROM obecnosci_na_lekcji AS o
INNER JOIN uczniowie AS u ON u.id = o.uczen
INNER JOIN lekcje AS l ON l.id = o.lekcja
INNER JOIN godziny AS g ON g.id = l.godzina
WHERE u.token = ? AND g.liczba_porzadkowa = ? AND l.dzien = ?;
;",[$_POST["token"],$_POST["nr_lekcji"],$dzien])[0]["obecny"];

if (!$czyObecny) {
    $db->query("UPDATE obecnosci_na_lekcji AS o
    INNER JOIN uczniowie AS u ON u.id = o.uczen
    INNER JOIN lekcje AS l ON l.id = o.lekcja
    INNER JOIN godziny AS g ON g.id = l.godzina
    SET o.obecny = ?, o.spozniony = ?
    WHERE u.token = ? AND g.liczba_porzadkowa = ? AND l.dzien = ?;
    ;",[$obecnosc,$spoznienie,$_POST["token"],$_POST["nr_lekcji"],$dzien]);
}



// echo checkIfInsidePolygon(
//     [[0,0],[2,2],[4,0],[2,1]],
//     [0,2]
// ) ? 'tru' : 'fals';
?>