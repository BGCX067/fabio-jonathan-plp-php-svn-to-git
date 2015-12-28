<?php

include_once "Tabuleiro.php";
include_once "TipoComputador.php";
include_once "Util.php";
include_once "Game.php";

function movePecaImprimeTabuleiro($tabuleiro,$px, $py, $ax,$ay){
	echo "-------------------------------\n";
	echo "$tabuleiro\n";
	echo "-------------------------------\n";
	
}


$tabuleiro = Tabuleiro::getInstance ();


echo "----- INICIAL -----" . "\n";
echo $tabuleiro;
//echo $tabuleiro[6][3]->getPeca();

$pc = new Game();
$pc->run();
$pc->run();
$pc->run();
$pc->run();
$pc->run();
$pc->run();
$pc->run();
$pc->run();
$pc->run();
$pc->run();
$pc->run();
$pc->run();
$pc->run();
$pc->run();
$pc->run();
$pc->run();
$pc->run();
$pc->run();
$pc->run();
$pc->run();
$pc->run();
$pc->run();
$pc->run();
$pc->run();
$pc->run();
$pc->run();
$pc->run();
$pc->run();
$pc->run();
$pc->run();
$pc->run();
$pc->run();
$pc->run();
$pc->run();
$pc->run();
$pc->run();
?>