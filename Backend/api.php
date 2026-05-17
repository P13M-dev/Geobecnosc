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
    if(!isset($_POST["token"]));
    $db = Database::get();
    $token = $db->query("SELECT zweryfikowany FROM uczniowie WHERE token = ?",[$_POST["token"]]);
    if(sizeof($token)==0) return 0;
    return $token[0]["zweryfikowany"];
}


if (isset($_SERVER["HTTP_AUTHORIZATION"]) && $_SERVER["HTTP_AUTHORIZATION"]!="") {
    
    $script = $_SERVER["HTTP_AUTHORIZATION"];
    $root = "/Backend/PHP";
    
    switch($script){
        case "dodajKlase":                  require "$root/Dodawanie/klasa.php";break;
        case "dodajUcznia":                 require "$root/Dodawanie/uczen.php";break;
        case "dodajPrzedmiot":              require "$root/Dodawanie/przedmiot.php";break;
        case "dodajNauczyciela":            require "$root/Dodawanie/nauczyciel.php";break;
        case "dodajGodzinyLekcji.php":      require "$root/Dodawanie/godzinyLekcji.php";break;
        case "dodajPlan.php":               require "$root/Dodawanie/plan.php";break; // dodaje LEKCJE na dany tydzień, a nie stał plan
        case "wybierzNauczycieli":          require "$root/Wybieranie/nauczyciele.php";break;  
        case "wybierzPrzedmioty":           require "$root/Wybieranie/przedmioty.php";break;
        case "wybierzKlasy":                require "$root/Wybieranie/klasy.php";break;
        case "wybierzImieNazwiskoN":        require "$root/Wybieranie/imieNazwiskoNauczyciela.php";break;
        case "wybierzImieNazwiskoU":        require "$root/Wybieranie/imieNazwiskoUcznia.php";break;
        case "wybierzUczniow":              require "$root/Wybieranie/uczniowie.php";break;
        case "wybierzGodziny":              require "$root/Wybieranie/godzinyLekcji.php";break;
        case "wybierzCalyPlan":             require "$root/Wybieranie/planAdmin.php";break;
        case "obecnosci":                   require "$root/Wybieranie/obecnosci.php";break;
        case "zalogujNauczyciel":           require "$root/Logowanie/nauczyciel.php";break;
        case "zalogujUczen":                require "$root/Logowanie/uczen.php";break;
        case "wylogujNauczyciel":           require "$root/Logowanie/wylogujNauczyciel.php";break;
        case "wylogujUczen":                require "$root/Logowanie/wylogujUczen.php";break;
        default:                            require "/Backend/404.html";break;
    };
} else {
    require "/Backend/404.html";
};

?>