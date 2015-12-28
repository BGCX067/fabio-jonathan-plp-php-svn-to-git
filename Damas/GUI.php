<?php

include_once "Tabuleiro.php";

$pecaAzul = "imagens/pecaAzul.gif";
$pecaVermelha = "imagens/pecaVermelha.gif";
$campoPreto = "imagens/campoPreto.gif";
$campoBranco = "imagens/campoBranco.gif";

function desenhaForms() {
	
	echo "      <h3 align='center'>
                <form method=post action=\"jogadas.php\">
                Antes: <input type='text' name='antes' />
                Depois: <input type='text' name='depois' />
                <input type='submit'  />
                </form>
                </h3>";
	
}

function desenhaTabuleiro($tabuleiro) {
	
	echo "<h3 align='center'>
              <font face='Times New Roman'>Jogo de Damas - Linguagem PHP</font>
              </h3>
              <p align='center'>&nbsp;</p>
                <p align='center'>";
	
	for($i = 1; $i <= 8; $i ++) {
		for($j = 1; $j <= 8; $j ++) {
			$matriz = $tabuleiro->getMatriz ();
			echo escolheImagemCampo ( $matriz [$i] [$j] );
		
		}

		echo "</br>";
	}

	desenhaForms ();
}

function escolheImagemCampo($campo) {
	global $pecaAzul;
	global $pecaVermelha;
	global $campoPreto;
	global $campoBranco;
	
	if ($campo->getPeca () == NULL) {
		if (! $campo->getCor ())
			return ("<img border='0' src=") . ($campoBranco) . (" alt='Logotipo da uARTE'>");
		else
			return ("<img border='0' src=") . ($campoPreto) . (" alt='Logotipo da uARTE'>");
	} 

	else if (! $campo->getPeca ()->getCor ())
		
		return ("<img border='0' src=") . ($pecaAzul) . (" alt='Logotipo da uARTE'>");
	
	else
		return ("<img border='0' src=") . ($pecaVermelha) . (" alt='Logotipo da uARTE'>");
	;
}