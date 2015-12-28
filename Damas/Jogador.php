<?php
include_once "Util.php";
include_once "JogadorException.php";

class Jogador {
	private $tipo;
	private $cor;
	
	public function __construct($tipo, $cor) {
		if (! ($cor === BLACK || $cor === WHITE))
			throw new JogadorException ( "Parametro Cor invalida" );
		
		$this->cor = $cor;
		$this->tipo = $this->factoryTipo ( $tipo );
	}
	
	public function play() {
		return $this->tipo->play ();
	}
	
	public function getTipo() {
		return $this->tipo->getTipo ();
	}
	
	public function getCor() {
		return $this->cor;
	}
	// Fabrica do Tipo de Jogador
	public function factoryTipo($tipo) {
		if ($tipo === HUMANO)
			return new TipoHumano ($this->cor);
		else if ($tipo === COMPUTADOR)
			return new TipoComputador ($this->cor);
		else
			throw new JogadorException ( "Parametro Cor invalida" );
	}

}