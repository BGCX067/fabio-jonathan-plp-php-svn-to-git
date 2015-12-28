<?php

include_once 'PecaException.php';
include_once 'Util.php';
include_once "PecaJogavel.php";

abstract class PecaAbstrata{
	
	protected $pos_x;
	protected $pos_y;
	protected $cor;
	
	const COR_ON = TRUE;
	const COR_OFF = FALSE;
	
	function __construct($pos_x, $pos_y, $cor) { // Inicializador
		if (gettype ( $pos_x ) !== "integer" && gettype ( $pos_y ) !== "integer")
			throw new PecaException ( "Entrada Invalida , Posição Invalida" );
		if (gettype ( $cor ) !== "boolean")
			throw new PecaException ( "Entrada Invalida , Cor invalida" );
		
		$this->setPosX ( $pos_x );
		$this->setPosY ( $pos_y );
		$this->cor = $cor;
	}
	
	function __destruct() { // Destruidor
		unset ( $this );
	}
	
	final function setPosX($x) {
		$this->pos_x = $x;
	}
	
	final function setPosY($y) {
		$this->pos_y = $y;
	}
		
	final function __call($metodo, $parametro) {
		die ("Erro Fatal : Metodo $metodo , com parametro $parametro invalidos ou inexistente");
	}
	
	public function getCor() {
		return $this->cor;
	}
	
	public function getPosY() {
		return $this->pos_y;
	}
	
	public function getPosX() {
		return $this->pos_x;
	}

	public static function isValidPosition($x,$y){
		return (isValidColuna($y) && isValidLinha($x));
			
	}
	
}



?>