<?php

class Preferencia {
	private $peca;
	private $move;
	private $valor;
	private $eat;
	
	public function __construct($peca, $move, $valor, $eat) {
		$this->peca = $peca;
		$this->move = $move;
		$this->valor = $valor;
		$this->eat = $eat;
	}
	
	public function getPeca() {
		return $this->peca;
	}
	
	public function getMove() {
		return $this->move;
	}
	public function getValor() {
		return $this->valor;
	}
	public function getEat() {
		return $this->eat;
	}
}

?>