<?php

echo checkIfInside([[[0,0],[2,1],[2,2]],[[2,1],[2,2],[4,0]]], [2,0.999]) ? 'tru' : 'fals';

class Vector2 {

    public $x; public $y;

    public function __construct($x, $y) {
        $this->x = $x;
        $this->y = $y;
    }
}

function sign($p1, $p2, $p3): float {
    return ($p1->x - $p3->x) * ($p2->y - $p3->y)
        - ($p2->x - $p3->x) * ($p1->y - $p3->y);
}

function pointInTriangle($pt, $v1, $v2, $v3): bool {

    $d1 = sign($pt, $v1, $v2);
    $d2 = sign($pt, $v2, $v3);
    $d3 = sign($pt, $v3, $v1);

    $hasNeg = ($d1 < 0) || ($d2 < 0) || ($d3 < 0);
    $hasPos = ($d1 > 0) || ($d2 > 0) || ($d3 > 0);

    return !($hasNeg && $hasPos);
}

function checkIfInside($triangles, $point): bool {

    $p = new Vector2($point[0], $point[1]);

    foreach ($triangles as $triangle) {

        $a = new Vector2($triangle[0][0], $triangle[0][1]);
        $b = new Vector2($triangle[1][0], $triangle[1][1]);
        $c = new Vector2($triangle[2][0], $triangle[2][1]);

        if (pointInTriangle($p, $a, $b, $c)) {
            return true;
        }
    }

    return false;
}