<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
require "/Backend/PHP/databaseHandler.php";

function isAdmin(){
    return isset($_SESSION["pozycja"]) && $_SESSION["pozycja"]==2;
}

function isTeacher(){
    return isset($_SESSION["pozycja"]) && $_SESSION["pozycja"]>0;
}

function isStudent(){
    
}

if (isset($_SERVER["HTTP_AUTHORIZATION"]) && $_SERVER["HTTP_AUTHORIZATION"]!="") {
    
    $script = $_SERVER["HTTP_AUTHORIZATION"];
    $root = "/Backend/PHP";
    require "{$root}/scriptAuthCodes.php";

    switch($script){
        case "dodajKlase":              require "$root/Dodawanie/dodajKlase.php";break;
        default:                        require "/Backend/404.html";break;
    };

} else {
    require "/Backend/404.html";
};

?>