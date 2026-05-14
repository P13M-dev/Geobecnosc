<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require "/Secure/Scripts/databaseHandler.php";
if (isset($_SERVER["HTTP_AUTHORIZATION"]) && $_SERVER["HTTP_AUTHORIZATION"]!="") {
    
    $script = $_SERVER["HTTP_AUTHORIZATION"];
    $root = "/Backend/PHP";
    require "{$root}/scriptAuthCodes.php";

    switch($script){
        case $code->ping:                   require"/";
        default:                            require "/Backend/404.html";
    };

};

?>