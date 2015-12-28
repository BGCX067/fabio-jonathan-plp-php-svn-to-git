<?php
include_once "TipoJogador.php";
include_once "Util.php";

class TipoHumano implements TipoJogador {
	
	public function getTipo(){
		return HUMANO;
	}
	
	public function play(){ // Play  Humano 
		
	}

}

?>