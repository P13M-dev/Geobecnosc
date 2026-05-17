<?php
if(!isStudent()) die;

if(!isset($_POST["pozycja"]));
if(!isset($_POST["nr_lekcji"]));
if(!isset($_POST["spoznienie"]));


$db = Database::get();
$obszarSzkoly = $db->query(
   "SELECT obszar_szkoly FROM dane_szkoly
    WHERE id = 1;"
);
$pozycja = json_decode($_POST["pozycja"]);
$obszarSzkoly = json_decode($obszarSzkoly[0]["obszar_szkoly"]);

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

$inside = true;

if(!checkIfInsidePolygon($obszarSzkoly,$pozycja)) $inside = false; // poza obszarem
if($_POST["spoznienie"])
$db->query("UPDATE o
SET o.obecny = ? , o.spozniony = ?
FROM obecnosci_na_lekcji AS o
INNER JOIN uczniowie AS u ON u.id = o.uczen AND u.token = ?; ");


// echo checkIfInsidePolygon(
//     [[0,0],[2,2],[4,0],[2,1]],
//     [0,2]
// ) ? 'tru' : 'fals';