<?php

include_once "Tabuleiro.php";
include_once "GUI.php";

$tabuleiro = Tabuleiro::getInstance ();

session_start();
$_SESSION['tabuleiro'] = serialize($tabuleiro);

desenhaTabuleiro($tabuleiro);

?>