<?php
include_once "Tabuleiro.php";
include_once "Util.php";
include_once "Jogador.php";

class Game {
	
	private $tabuleiro;
	private $vezJogador1;
	private $jogador1;
	private $jogador2;
	
	public function __construct() {
		$this->tabuleiro = Tabuleiro::getInstance ();
		$this->jogador1 = new Jogador ( COMPUTADOR, BLACK );
		$this->jogador2 = new Jogador ( COMPUTADOR, WHITE );
		$this->vezJogador1 = True;
	}
	
	public function imprimeTabuleiro() {
		echo "-------------------------------\n";
		echo "$this->tabuleiro\n";
		echo "-------------------------------\n";
	}
	
	public function mudaVez() {
		$this->vezJogador1 = ! $this->vezJogador1;
	}
	
	public function run() {
		// Enquanto o jogo poder continuar  , ou seja , tiver jogo e nao estiver pausado
		
		$move = 0;
		//while ( $this->tabuleiro->tabuleiroEnd () && ($move <= 1)) {
			
			$move++;
			$jogadorVez = $this->jogadorDaVez (); // Pega o jogador que estiver na vez;
			

			// A quantidade das pecas de cada cor , antes da jogada
			$lastTotalPretas = $this->tabuleiro->getTotalPretas ();
			$lastTotalBrancas = $this->tabuleiro->getTotalBrancas ();
			
			// Jogada do jogadorDaVez
			$array = $jogadorVez->play ();
			$pecaDoMovimento = $this->tabuleiro->getPeca ( $array [0], $array [1] );
			
			// testa o movimento da jogada
			//try {
				$this->tabuleiro->jogaPeca ( $array [0], $array [1], $array [2], $array [3] );
			//} catch ( Exception $e ) { // Trata as excecoes
			

			//}
			
			// Pega as quantidades de pecas depois da comida
			$newTotalPretas = $this->tabuleiro->getTotalPretas ();
			$newTotalBrancas = $this->tabuleiro->getTotalBrancas ();
			
			// Se for nao for uma jogada de multiplas comidas , altera a vez
			if (! ($lastTotalBrancas !== $newTotalBrancas && $lastTotalPretas !== $newTotalPretas && $this->tabuleiro->isComivel ( $pecaDoMovimento->getPosX (), $pecaDoMovimento->getPosY () ))) {
				$this->mudaVez ();
			}
			$this->imprimeTabuleiro();
		
		//}
		// Tratar o vencedor aqui 
	}
	
	private function jogadorDaVez() {
		if ($this->vezJogador1)
			return $this->jogador1;
		else
			return $this->jogador2;
	}

}
?>