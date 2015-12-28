<?php
include_once "TabuleiroException.php";
include_once "Util.php";
include_once "Peca.php";

class Campo {
	
	private $peca;
	private $cor;
	
	public function __construct($cor, $peca) {
		$this->peca = $peca;
		$this->cor = $cor;
	}
	
	public function setPeca($peca) {
		if ($peca instanceof PecaJogavel || $peca === NULL)
			$this->peca = $peca;
		else
			throw new TabuleiroException ( "O objeto do campo nao eh do tipo PecaJogavel" );
	}
	
	public function getCor() {
		return $this->cor;
	}
	
	public function getPeca() {
		return $this->peca;
	}
	
	public function __toString() {
		if ($this->peca !== NULL)
			return $this->peca->__toString ();
		elseif ($this->cor === CAMPO_PRETO)
			return "0";
		else
			return "1";
	}
}

class Tabuleiro {
	
	private $matriz;
	private $totalPretas;
	private $totalBrancas;
	
	private static $tabuleiro;
	
	private function __construct() {
		$this->inicializaCampo ();
		$this->inicializaPlayers ();
		$this->totalBrancas = 12;
		$this->totalPretas = 12;
	}
	
	private function inicializaCampo() {
		
		$this->matriz = array (1 => $this->setaLinha ( 1 ), 2 => $this->setaLinha ( 2 ), 3 => $this->setaLinha ( 3 ), 4 => $this->setaLinha ( 4 ), 5 => $this->setaLinha ( 5 ), 6 => $this->setaLinha ( 6 ), 7 => $this->setaLinha ( 7 ), 8 => $this->setaLinha ( 8 ) );
	}
	
	private function setaLinha($linha) {
		$array = array ();
		for($coluna = 1; $coluna < 9; $coluna ++) {
			//A linha eh inicializada com sua cor e objeto Nulo como objeto contido nele (peca da dama).
			$array [$coluna] = new Campo ( $this->getCorCampo ( $linha, $coluna ), NULL );
		}
		return $array;
	}
	
	private function getCorCampo($x, $y) {
		return (($x + $y) % 2 == 0) ? CAMPO_BRANCO : CAMPO_PRETO;
	}
	
	private function inicializaPlayerCima() {
		for($linha = 1; $linha < 4; $linha ++) {
			for($coluna = 1; $coluna < 9; $coluna ++) {
				if ($this->matriz [$linha] [$coluna]->getCor () == CAMPO_PRETO) {
					$this->matriz [$linha] [$coluna]->setPeca ( new Peca ( $linha, $coluna, BLACK, FALSE ) );
				}
			}
		}
	}
	
	private function inicializaPlayerBaixo() {
		for($linha = 6; $linha < 9; $linha ++) {
			for($coluna = 1; $coluna < 9; $coluna ++) {
				if ($this->matriz [$linha] [$coluna]->getCor () == CAMPO_PRETO) {
					$this->matriz [$linha] [$coluna]->setPeca ( new Peca ( $linha, $coluna, WHITE, FALSE ) );
				}
			}
		}
	}
	
	private function inicializaPlayers() {
		$this->inicializaPlayerCima ();
		$this->inicializaPlayerBaixo ();
	}
	
	public function __toString() {
		$retorno = "";
		foreach ( $this->matriz as $linha ) {
			foreach ( $linha as $elemento ) {
				$retorno .= "| " . $elemento . " |";
			}
			$retorno .= "\n";
		}
		return $retorno;
	}
	
	// Funfando
	public function movePeca($prevX, $prevY, $aftX, $aftY) {
		$Campo1 = $this->matriz [$prevX] [$prevY];
		$Campo2 = $this->matriz [$aftX] [$aftY];
		$Peca = $Campo1->getPeca ();
		$Peca->move ( $aftX, $aftY );
		$Campo2->setPeca ( $Peca );
		$this->delPeca ( $prevX, $prevY );
	}
	// Funfando
	private function delPeca($x, $y) {
		$this->matriz [$x] [$y]->setPeca ( NULL );
	}
	
	private function pecaComestivel($Peca1, $Peca2) {
		return $Peca1->getCor () != $Peca2->getCor ();
	}
	
	//Pega o maior movimento da peca e ve se os parametros sao possiveis.
	//Retorna um booleano.
	private function canMove($prevX, $prevY, $aftX, $aftY) {
		return ($this->getPeca ($prevX,$prevY)->max_Move() >= abs($prevX - $aftX)) && ($this->getPeca ($prevX,$prevY)->max_Move () >= abs($prevY - $aftY));
	}
	private function decrementaPecas($x, $y) {
		if ($this->getPeca ( $x, $y )->getCor () === BLACK)
			$this->totalPretas --;
		else
			$this->totalBrancas --;
	}
	private function isComestivel($Peca) {
		$x = $Peca->getPosX ();
		$y = $Peca->getPosY ();
		$direcoes = array (0, 0, 0, 0 ); // Representa as direcoes que a peca pode se mover
		// Retorna um array com as posicoes que deve se mover caso aja pecas para comer
		// Se nao , retorna null
		for($i = 0; $i <= $Peca->max_Move (); $i ++) {
			
			// Pega as pecas de todas as direcoes que se pode andar 
			$Peca1 = NULL;
			$Peca2 = NULL;
			$Peca3 = NULL;
			$Peca4 = NULL;
			
			if (PecaAbstrata::isValidPosition ( $x + $i, $y + $i )) {
				$Peca1 = $this->matriz [$x + $i] [$y + $i]->getPeca ();
			}
			if (PecaAbstrata::isValidPosition ( $x - $i, $y + $i )) {
				$Peca2 = $this->matriz [$x - $i] [$y + $i]->getPeca ();
			}
			if (PecaAbstrata::isValidPosition ( $x + $i, $y - $i )) {
				$Peca3 = $this->matriz [$x + $i] [$y - $i]->getPeca ();
			}
			if (PecaAbstrata::isValidPosition ( $x - $i, $y - $i )) {
				$Peca4 = $this->matriz [$x - $i] [$y - $i]->getPeca ();
			}
			
			/** testa para cada direcao , se puder comer continue , se nao puder e tiver uma 
			 * peca no meio , marque como indevido (-1)
			 */
			
			if ($direcoes [0] === 0 && $Peca1 !== NULL && $this->pecaComestivel ( $Peca, $Peca1 )) {
				$direcoes [0] = - 1;
				if (PecaAbstrata::isValidPosition ( $x + $i + 1, $y + $i + 1 ) && $this->matriz [$x + $i + 1] [$y + $i + 1]->getPeca () === NULL) { // Se puder comer
					$direcoes [0] = array ($x + $i + 1, $y + $i + 1 ); // Marque essa direcao com 1
				

				}
			}
			if ($direcoes [1] === 0 && $Peca2 !== NULL && $this->pecaComestivel ( $Peca, $Peca2 )) {
				$direcoes [1] = - 1;
				if (PecaAbstrata::isValidPosition ( $x - $i - 1, $y + $i + 1 ) && $this->matriz [$x - $i - 1] [$y + $i + 1]->getPeca () === NULL) {
					$direcoes [1] = array ($x - $i - 1, $y + $i + 1 );
				}
			}
			if ($direcoes [2] === 0 && $Peca3 !== NULL && $this->pecaComestivel ( $Peca, $Peca3 )) {
				$direcoes [2] = - 1;
				if (PecaAbstrata::isValidPosition ( $x + $i + 1, $y - $i - 1 ) && $this->matriz [$x + $i + 1] [$y - $i - 1]->getPeca () === NULL) {
					$direcoes [2] = array ($x + $i + 1, $y - $i - 1 );
				}
			}
			
			if ($direcoes [3] === 0 && $Peca4 !== NULL && $this->pecaComestivel ( $Peca, $Peca4 )) {
				$direcoes [3] = - 1;
				if (PecaAbstrata::isValidPosition ( $x - $i - 1, $y - $i - 1 ) && $this->matriz [$x - $i - 1] [$y - $i - 1]->getPeca () === NULL) {
					$direcoes [3] = array ($x - $i - 1, $y - $i - 1 );
				}
			}
		}
		return $direcoes;
	}
	
	private function testaMaxCome($Peca,$caminho) {
		$movimentos = $this->isComestivel ( $Peca );
		$result = 1;
		foreach ( $movimentos as $chave => $valor ) {
			$valor_aux = 0;
			if (is_array ( $valor )) {
				if(!in_array($valor,$caminho)){
				$caminho[] = $valor;
				$valor_aux = 1 + $this->testaMaxCome ( new Peca ( $valor [0], $valor [1], $Peca->getCor (), $Peca->isDama () ),$caminho );
				}
			} else {
				continue;
			}
			if ($valor_aux > $result) {
				$result = $valor_aux;
			}
		}
		return $result;
	}
	
	public function isComivel($Peca) {
		
		$result = array ();
		$dimensoes = $this->isComestivel ( $Peca );
		$comidas = array ();
		
		foreach ( $dimensoes as $chave => $valor ) {
			if (is_array ( $valor )) {
				$value_aux = $this->testaMaxCome ( new Peca ( $valor [0], $valor [1], $Peca->getCor (), $Peca->isDama () ) , array() );
				$comidas [] = array ($chave, $valor, $value_aux );
			} else {
				$result [$chave] = $valor;
			}
		}
		
		$pos = - 1;
		$valor = - 1;
		
		foreach ( $comidas as $j => $teste ) {
			if ($teste [2] > $valor) {
				$pos = $j;
				$valor = $teste [2];
			}
		}
		
		foreach ( $comidas as $j => $valores ) {
			if ($j == $pos) {
				$result [$teste [0]] = $teste [1];
			} else {
				$result [$teste [0]] = 0;
			}
		}
		return $result;
	}
	
	public function getPecasBrancas() {
		$pecas = array ();
		for($i = 1; $i < 9; $i ++) {
			for($j = 1; $j < 9; $j ++) {
				$Peca = $this->getPeca ( $i, $j );
				//print_r($Peca);
				if (($Peca !== NULL) && ($Peca->getCor () === WHITE)) {
					$pecas [] = $Peca;
				}
			}
		}
		return $pecas;
	}
	public function getPecasPretas() {
		$pecas = array ();
		for($i = 1; $i < 9; $i ++) {
			for($j = 1; $j < 9; $j ++) {
				$Peca = $this->getPeca ( $i, $j );
				//print_r($Peca);
				if (($Peca !== NULL) && ($Peca->getCor () === BLACK)) {
					$pecas [] = $Peca;
				}
			}
		}
		return $pecas;
	}
	
	public function getPeca($x, $y) {
		return ($this->matriz [$x] [$y]->getPeca ());
	}
	
	public function canCoroar($peca) {
		return ($peca->getCor () == BLACK && $peca->getPosX () == 8) || ($peca->getCor () == WHITE && $peca->getPosX () == 1);
	}
	
	public function Coroar($peca) {
		$peca->setDama ();
	}
	
	public function jogaPeca($prevX, $prevY, $aftX, $aftY) {
		//Testa a condicao de se o campo de antes possui uma peca dentro dele.
		if (! PecaAbstrata::isValidPosition ( $prevX, $prevY ) || $this->getPeca ( $prevX, $prevY ) == NULL)
			throw new TabuleiroException ( "O campo de origem nao tem peca nenhuma." );
		if (! PecaAbstrata::isValidPosition ( $aftX, $aftY ) || $this->getPeca ( $aftX, $aftY ) !== NULL)
			throw new TabuleiroException ( "O campo de destino ja esta ocupado." );
		
		$direcoes = $this->isComivel ( $this->getPeca ( $prevX, $prevY ) );
		/**
		 * testa se a direcao do movimento � possivel , de acordo com a peca que tem que ser
		 * comida
		 */
		$hasMove = False;
		
		$condicao1 = is_array ( $direcoes [0] ) && PecaAbstrata::isValidPosition ( $direcoes [0] [0], $direcoes [0] [1] );
		$condicao2 = is_array ( $direcoes [1] ) && PecaAbstrata::isValidPosition ( $direcoes [1] [0], $direcoes [1] [1] );
		$condicao3 = is_array ( $direcoes [2] ) && PecaAbstrata::isValidPosition ( $direcoes [2] [0], $direcoes [2] [1] );
		$condicao4 = is_array ( $direcoes [3] ) && PecaAbstrata::isValidPosition ( $direcoes [3] [0], $direcoes [3] [1] );
		
		if ($condicao1 && ! $hasMove) {
			if ($direcoes [0] [0] == $aftX && $direcoes [0] [1] == $aftY) {
				$hasMove = True;
				$this->movePeca ( $prevX, $prevY, $aftX, $aftY );
				$this->decrementaPecas ( $aftX - 1, $aftY - 1 );
				$PecaMorta = $this->getPeca ( $aftX - 1, $aftY - 1 );
				$this->delPeca ( $aftX - 1, $aftY - 1 );
				unset ( $PecaMorta );
			
			}
		}
		if ($condicao2 && ! $hasMove) {
			if ($direcoes [1] [0] == $aftX && $direcoes [1] [1] == $aftY) {
				$hasMove = True;
				$this->movePeca ( $prevX, $prevY, $aftX, $aftY );
				$this->decrementaPecas ( $aftX + 1, $aftY - 1 );
				$PecaMorta = $this->getPeca ( $aftX + 1, $aftY - 1 );
				$this->delPeca ( $aftX + 1, $aftY - 1 );
				unset ( $PecaMorta );
			}
		}
		if ($condicao3 && ! $hasMove) {
			if ($direcoes [2] [0] == $aftX && $direcoes [2] [1] == $aftY) {
				$hasMove = True;
				$this->movePeca ( $prevX, $prevY, $aftX, $aftY );
				$PecaMorta = $this->getPeca ( $aftX - 1, $aftY + 1 );
				$this->decrementaPecas ( $aftX - 1, $aftY + 1 );
				$this->delPeca ( $aftX - 1, $aftY + 1 );
				unset ( $PecaMorta );
			}
		}
		if ($condicao4 && ! $hasMove) {
			if (($direcoes [3] [0] == $aftX && $direcoes [3] [1] == $aftY)) {
				$hasMove = True;
				$this->movePeca ( $prevX, $prevY, $aftX, $aftY );
				$this->decrementaPecas ( $aftX + 1, $aftY + 1 );
				$PecaMorta = $this->getPeca ( $aftX + 1, $aftY + 1 );
				$this->delPeca ( $aftX + 1, $aftY + 1 );
				unset ( $PecaMorta );
			}
		}
		if (($condicao1 || $condicao2 || $condicao3 || $condicao4) && ! $hasMove) {
			throw new Exception ( "Erro , Deve comer a peca" );
		} /**
		 * Se nao ha nenhuma peca para comer obrigatoriamente
		 */
		
		// FUNCIONANDO 
		

		elseif (! $hasMove) { // Testa se o movimento eh possivel pelo numero de casas movidas
			$direcao_move = diagonalMove ( $aftX - $prevX, $aftY - $prevY );
			if ($this->canMove ( $prevX, $prevY, $aftX, $aftY )) { //Testa se o movimento esta na direcao que a peca pode ir
				echo "WOWOWOWWO\n";
				if ((($this->getPeca ( $prevX, $prevY )->getCor () == BLACK) && $direcao_move [1] > 0) || $this->getPeca ( $prevX, $prevY )->isDama ()) {
					$this->movePeca ( $prevX, $prevY, $aftX, $aftY );
				} else if ((($this->getPeca ( $prevX, $prevY )->getCor () == WHITE) && $direcao_move [1] < 0) || $this->getPeca ( $prevX, $prevY )->isDama ()) {
					$this->movePeca ( $prevX, $prevY, $aftX, $aftY );
				} else {
					throw new Exception ( "Erro , Mova a peca apenas para frente" );
				}
			} else 

			{
				throw new Exception ( "Erro , Nao pode mover tantas casas" );
			}
		}
	}
	
	public function tabuleiroEnd() {
		return ($this->getTotalPretas () == 0) || ($this->gettotalBrancas () == 0);
	}
	
	public function getTotalBrancas() {
		return $this->totalBrancas;
	}
	
	public function getTotalPretas() {
		return $this->totalPretas;
	}
	public function contemPeca($x, $y) {
		return (! $this->getPeca ( $x, $y ) == NULL);
	}
	//Singleton
	public static function getInstance() {
		if (Tabuleiro::$tabuleiro === NULL)
			Tabuleiro::$tabuleiro = new Tabuleiro ( );
		
		return Tabuleiro::$tabuleiro;
	}

	public function getMatriz(){
		return $this->matriz;
	}

}
?>