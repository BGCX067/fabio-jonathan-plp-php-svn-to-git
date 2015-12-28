<?php

define ("NUM_MAX_COLUNAS", 8);
define ("NUM_MAX_LINHAS", 8);

define ("NUM_MIN_COLUNAS", 1);
define ("NUM_MIN_LINHAS", 1);

define("MAX_MOVE_NORMAL", 1);
define("MAX_MOVE_DAMA", 8);

define("CAMPO_PRETO",False);
define("CAMPO_BRANCO",True);

define("BLACK",False);
define("WHITE",True);

define("HUMANO","human");
define("COMPUTADOR","npc");

define("MIN_PREF",-999999999);
//define("PECA_ENCOSTADA",-1);
//define("PECA_COMER",0);

//Adotando o referencial do Comeco da tabela.
//define("DIAGONAL_NE",array(+1,-1));
//define("DIAGONAL_NO",array(-1,-1));
//define("DIAGONAL_SE",array(+1,+1));
//define("DIAGONAL_SO",array(-1,+1));

function isValidLinha($x){
	return ($x >= NUM_MIN_LINHAS && $x <= NUM_MAX_LINHAS);
}

function isValidColuna($y){
	return ($y >= NUM_MIN_COLUNAS && $y <= NUM_MAX_COLUNAS);
}

function diagonalMove($x,$y){
	if($x < 0 && $y < 0){
		return array(-1,-1);
	}else if($x > 0 && $y >0){
		return array(+1,+1);
	}else if($x < 0 && $y > 0){
		return array(+1,-1);
	}else{
		return array(-1,+1);
	}
}

?>