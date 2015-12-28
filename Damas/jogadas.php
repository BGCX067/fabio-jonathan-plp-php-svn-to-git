<?php

include_once "GUI.php";
include_once "Tabuleiro.php";

$antes = $_POST["antes"];
$depois = $_POST["depois"];

$prevX = $antes[0];
$prevY = $antes[1];

$posX = $depois[0];
$posY = $depois[1];

session_start();
if (isset($_SESSION["tabuleiro"])) {
	$tabuleiro = unserialize($_SESSION['tabuleiro']);
}

try {
	$tabuleiro->jogaPeca($prevX, $prevY, $posX, $posY);
} catch(Exception $e){ 
	
}


$_SESSION['tabuleiro'] = serialize($tabuleiro);

desenhaTabuleiro($tabuleiro);

?>
