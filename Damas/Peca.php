<?php

include_once "PecaJogavel.php";
include_once "PecaException.php";
include_once "Util.php";
include_once "PecaAbstrata.php";

class Peca extends PecaAbstrata implements PecaJogavel{
	
	private $tipo;
	
	function __construct($pos_x, $pos_y, $cor , $tipo) {
		if (parent::isValidPosition ( $pos_x, $pos_y ))
			parent::__construct ( $pos_x, $pos_y, $cor );
		else
			throw new PecaException ( "Posicao de Peca Invalida." );
		if (gettype($tipo) === gettype(False)){
			$this->tipo = $tipo;
		}else{
			throw new PecaException ( "Tipo invalido" );
		}
	}
	
	function setDama() {
		$this->tipo = True;
	}
	
	function move($x , $y){
		parent::setPosX($x);
		parent::setPosY($y);
	}
	
	function isDama() {
		return $this->tipo;
	}
	
	function max_Move() {
		return ($this->isDama())? MAX_MOVE_DAMA : MAX_MOVE_NORMAL;
	}
	
	function __toString() {
		if ($this->getCor () === BLACK)
			return "P";
		else
			return "B";
	}
	function canMove($x,$y){
		$direcoes = diagonalMove($this->getPosX() - $x ,$this->getPosY()- $y);
		if(($this->getCor() && $direcoes[1] < 0) || ((!$this->getCor()) && $direcoes[1] > 0)) return True;
		
	}
}

//$a = new PecaNormal(1,1,True);
//$b = new Peca($a);
//
//print_r($b);
?>