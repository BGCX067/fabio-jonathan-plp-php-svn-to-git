<?php

include_once "Tabuleiro.php";
include_once "TipoJogador.php";
include_once "Util.php";
include_once "PecaAbstrata.php";
include_once "Preferencia.php";

class TipoComputador implements TipoJogador {
	
	private $cor;
	
	public function __construct($cor) {
		$this->cor = $cor;
	}
	
	public function getTipo() {
		return COMPUTADOR;
	}
	public function play() { // Agente Inteligente
		$tabuleiro = Tabuleiro::getInstance ();
		$pecas = $this->getPecasComp ( $tabuleiro );
		$preferencias = $this->getPreferencias ( $pecas, $tabuleiro );
		$movimento = array ();
		$maxPref = MIN_PREF;
		$hasEat = false;
		foreach ( $preferencias as $i => $chave ) {
			$valor = $chave->getValor ();
			$move = $chave->getMove ();
			$eat = $chave->getEat ();
			$peca = $chave->getPeca ();
			echo "VALOR : $valor \n";
			echo "Peca\n";
			print_r ( $peca );
			echo "Move\n";
			print_r ( $move );
			if ($eat)
				$hasEat = True;
			if ($valor >= $maxPref && ! ($hasEat ^ $eat) && $peca !== NULL && $move !== NULL) {
				$movimento [0] = $peca->getPosX ();
				$movimento [1] = $peca->getPosY ();
				$movimento [2] = $move [0];
				$movimento [3] = $move [1];
				$maxPref = $valor;
			}
		
		}
		return $movimento;
	
	}
	// Retorna as pecas do computador
	public function getPecasComp($tabuleiro) {
		if ($this->cor == WHITE)
			return $tabuleiro->getPecasBrancas ();
		else
			return $tabuleiro->getPecasPretas ();
	}
	
	// Pega os melhores movimentos e poe em um array ordenados , com as chaves como movimentos
	// E os valores como a preferencia
	

	public function getPreferencias($pecas, $tabuleiro) {
		$preference = array ();
		foreach ( $pecas as $chave => $peca ) {
			$teste = $this->testaMove ( $peca, $tabuleiro );
			$preference [] = new Preferencia ( $peca, $teste [0], $teste [1], $teste [2] );
		}
		return $preference;
	}
	
	private function testandoMove($peca, $valor, $caminho, $tabuleiro) {
		$bestValue = MIN_PREF;
		$isComivel = $tabuleiro->isComivel ( $peca );
		
		foreach ( $isComivel as $i => $chave ) {
			$value = MIN_PREF;
			
			$direcao = $this->direcaoMove ( $i );
			
			$x = $direcao [0];
			$y = $direcao [1];
			
			if ($chave === - 1)
				$value = - 10;
			elseif ($chave === 0) {
				$value = $valor - 1;
			} elseif (is_array ( $chave )) {
				if (! in_array ( $chave, $caminho )) {
					$caminho [] = $chave;
					$intermediario = $this->testandoMove ( new Peca ( $chave [0], $chave [1], $peca->getCor (), $peca->isDama () ), $valor + 2, $caminho, $tabuleiro );
					if ($intermediario >= $value) {
						$value = $intermediario;
					}
				} else {
					$value = MIN_PREF;
				}
			}
			
			if ($value > $bestValue) {
				$bestValue = $value;
			}
		}
		
		return $bestValue;
	}
	public function testaMove($peca, $tabuleiro) {
		$eat = false;
		$retorno = array ();
		$melhorPref = MIN_PREF;
		$come = $tabuleiro->isComivel ( $peca );
		foreach ( $come as $i => $chave ) {
			$valor = MIN_PREF;
			$pref = MIN_PREF;
			$move = array ();
			
			$direcao = $this->direcaoMove ( $i );
			
			$x = $direcao [0];
			$y = $direcao [1];
			
			//BUGADOOOO TCHOOOOW!!!!
			if ($peca->isDama () || $peca->canMove ( $x, $y )) {
				if ($chave === - 1 || $chave === 0 && ! $eat) {
					$prefAux = MIN_PREF;
					if ($chave === - 1)
						$valor = - 4;
					else
						$valor = 0;
					for($j = $peca->max_Move (); $j > 0; $j --) {
						$moveAux = array ($peca->getPosX () + $x * $j, $peca->getPosY () + $y * $j );
						if (PecaAbstrata::isValidPosition ( $moveAux [0], $moveAux [1] )) {
							if ($tabuleiro->contemPeca ( $moveAux [0], $moveAux [1] )) {
								$testeAux = - 100000000;
							} else {
								$testeAux = $this->testandoMove ( new Peca ( $moveAux [0], $moveAux [1], $peca->getCor (), $peca->isDama () ), $valor, array ($move ), $tabuleiro );
							}
							if ($prefAux < $testeAux) {
								$move [0] = $moveAux [0];
								$move [1] = $moveAux [1];
								$prefAux = $testeAux;
							}
						}
					}
					$pref = $prefAux;
				} elseif (is_array ( $chave )) {
					$move [0] = $chave [0];
					$move [1] = $chave [1];
					$valor = 3;
					$eat = True;
					if (PecaAbstrata::isValidPosition ( $move [0], $move [1] ))
						$pref = $this->testandoMove ( new Peca ( $move [0], $move [1], $peca->getCor (), $peca->isDama () ), $valor, array ($move ), $tabuleiro );
				}
			}
			if ($pref > $melhorPref) {
				$melhorPref = $pref;
				$retorno = $move;
			}
		}
		return array ($retorno, $melhorPref, $eat );
	}
	private function direcaoMove($i) {
		
		$x = 0;
		$y = 0;
		switch ($i) {
			case 0 :
				$x = 1;
				$y = 1;
				break;
			case 1 :
				$x = - 1;
				$y = 1;
				break;
			case 2 :
				$x = 1;
				$y = - 1;
				break;
			case 3 :
				$x = - 1;
				$y = - 1;
				break;
		}
		return array ($x, $y );
	
	}
	// Para cada Peça sua no tabuleiro
// teste os movimentos dessa peça
//Para cada cada peça comida +2 de preferencia desse movimento
//Se for comida -1 de preferencia
//Mova a pessa de maior preferencia
//Caso aja empate
//Mova qualquer uma
//Caso todas as preferencias sejam 0
//Mova a qualquer o mais proximo possivel de outra Peça inimiga
}

?>