<?php
session_start();

if(!isTeacher()) die;

$dane = ["imie"=>$_SESSION["imie"],"nazwisko"=>$_SESSION["nazwisko"]];

echo json_encode($dane);

?>