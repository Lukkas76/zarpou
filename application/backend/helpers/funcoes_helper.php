<?php
/**
 * Helper function for Diversos
 *
 * @author Jorge Ribeiro Junior
 * @version 1.0
 */
function assets_url($uri = ''){
	$url = get_instance()->config->base_url($uri);
	return str_replace('/admin/', '/assets/', $url);
}

function dvd($data){
	echo '<pre>';
	die(var_dump($data));
}

/**
 * [formataZeroEsquerda description]
 * @method  formataZeroEsquerda
 *
 * @author nickf
 * @version [1.0.0]
 * @date    2015-12-18
 * @param   [type]              $valor        [description]
 * @param   [type]              $zeroEsquerda [description]
 * @return  [type]                            [description]
 */
function formataZeroEsquerda($valor, $zeroEsquerda){
	return str_pad($valor, $zeroEsquerda, "0", STR_PAD_LEFT);
}

function formataData($data, $db = false, $time = false) {
	if($db === false && $time == false) {
		return date('d/m/Y', strtotime($data));
	} elseif($db == true && $time == false) {
		return implode('-', array_reverse(explode('/', $data)));
	} elseif($time == true){
		return date('d/m/Y H:m:s', strtotime($data));
	}
}
function formataDecimalUser($valor, $casasDecimais = 2){
	return number_format($valor, $casasDecimais, ',', '.');
}

function formataDecimalBanco($valor){
	return doubleval(str_replace(array('.', ','), array('', '.'), $valor));
}

function formataHora($time){
	return strftime("%H:%M", strtotime($time));
	// return substr($time, 0, 5);
}

function formataValorMonetario($valor, $casasDecimais = 2, $banco = FALSE){
	if($banco === FALSE)
		return number_format($valor, $casasDecimais, ',', '.');
	else
		return doubleval(str_replace(array('.', ','), array('', '.'), $valor));
}


function MesPorExtenso($mes){
	$meses = array (
		1 => "Janeiro", 
		2 => "Fevereiro", 
		3 => "Março", 
		4 => "Abril", 
		5 => "Maio", 
		6 => "Junho", 
		7 => "Julho", 
		8 => "Agosto", 
		9 => "Setembro", 
		10 => "Outubro", 
		11 => "Novembro", 
		12 => "Dezembro");

	return $meses[$mes];
}

function diaSemana($data = '', $bitRetorno = false){
	// Traz o dia da semana para qualquer data informada
	$dia = substr($data, 0, 2);
	$mes = substr($data, 3, 2);
	$ano = substr($data, 6, 4);
	
	$intDiaSemana = date("w", mktime(0, 0, 0, $mes, $dia, $ano));
	switch($intDiaSemana) {
		case"0":
			$txtDiaSemana = "Domingo";
			break;
		case"1":
			$txtDiaSemana = "Segunda Feira";
			break;
		case"2":
			$txtDiaSemana = "Terça Feira";
			break;
		case"3":
			$txtDiaSemana = "Quarta Feira";
			break;
		case"4":
			$txtDiaSemana = "Quinta Feira";
			break;
		case"5":
			$txtDiaSemana = "Sexta Feira";
			break;
		case"6":
			$txtDiaSemana = "Sábado";
			break;
	}

	if($bitRetorno)
		return $intDiaSemana;
	else
		return $txtDiaSemana;
	;
}

/**
 * [in_array_field - Determinar se um campo de objeto/array corresponde a um determinado dado]
 * @param  string  		$needle       	[Variável a ser pesquisada dentro do Array]
 * @param  string  		$needle_field 	[Campo ou item do array que deverá sre utilizado para a pesquisa]
 * @param  objeto  		$haystack     	[Array com o conteúdo para pesquisa]
 * @param  boolean 		$strict       	[description]
 * @return boolean                		[Retorna true ou false]
 */
function in_array_field($needle, $needle_field, $haystack, $strict = false, $retorna_dado = false) { 
    if ($strict) { 
        foreach ($haystack as $item) 
            if (isset($item->$needle_field) && $item->$needle_field === $needle) 
                return true; 
    } 
    else { 
        foreach ($haystack as $item) 
            if (isset($item->$needle_field) && $item->$needle_field == $needle) {
            	if($retorna_dado)
            		return $item;
            	else
                	return true; 
            }
    } 
    return false; 
}

function FormataMesPorExtenso($mes){
	$meses = array (
		1 => "Janeiro", 
		2 => "Fevereiro", 
		3 => "Março", 
		4 => "Abril", 
		5 => "Maio", 
		6 => "Junho", 
		7 => "Julho", 
		8 => "Agosto", 
		9 => "Setembro", 
		10 => "Outubro", 
		11 => "Novembro", 
		12 => "Dezembro");

	return $meses[$mes];
} 

/**
 * Função para poder encurtar a URL de criptografia
 * @param  string 	$value 	Dado a ser criptogragado
 * @return string        	Dado criptografado
 */
function encode($value = ''){
	$CI = & get_instance();
	return $CI->encrypt->encode($value);
}

/**
 * Função para poder encurtar a URL de decriptação
 * @param  string 	$value 	Dado a ser decriptado
 * @return string 			Dados decriptado
 */
function decode($value = ''){
	$CI = & get_instance();
	return $CI->encrypt->decode($value);
}

/**
 *  [imprimiLinha - Cria o HTML para poder realizar a impressão do mapa de sala]
 *  @method  imprimiLinha
 *  @param   [integer]       	$intLinha   [número da linha que será impressa]
 *  @param   [Array]       		$mapeamento [array contendo todos os dados do mapa da sala]
 *  @return  [String]                   	[retorna o HTML da linha que está sendo impressa]
 */
// function imprimir_linha_mapa($intLinha, $mapeamento, $creditos, $usuarioPossuiReserva, $arrayMapaBicicletaReservada, $reservas_realizadas){
// 	$CI = & get_instance();
// 	$impressaoMapa = '';
// 	$impressaoMapa .= '<div class="linha">';
// 	foreach($mapeamento as $mapa){
// 		if((int)$mapa->intNumLinha == (int)$intLinha){
// 			$retorno_pesquisa = in_array_field($mapa->id, 'idMapaBicicletaSala', $reservas_realizadas, false, true);
// 			if(!$retorno_pesquisa){
// 				if($mapa->idTipoPosicao == 1 && (int)$creditos >= (int)$mapa->intQtdCreditos){
// 					$impressaoMapa .= '	<a id="bike_' . $mapa->id . '" class="' . $mapa->txtClass . ' reserva-bike" style="' . $mapa->txtStyle . '" href="#"
// 									  	onclick="adicionarReserva(' . $mapa->id . ',\'' . $mapa->txtPosicao . '\')"> '.formataZeroEsquerda($mapa->txtPosicao, 2).'</a>';
// 				}else if($mapa->idTipoPosicao == 1){
// 					$impressaoMapa .= '	<span class="' . $mapa->txtClass . '" style="' . $mapa->txtStyle . '"><a id="bike_' . $mapa->id . '" class="' . $mapa->txtClass . ' reserva-bike" href="#" onclick="alterarReserva(' . $mapa->id . ',\'\', \'bike\', \''. $mapa->txtPosicao.'\')">'. $mapa->txtPosicao.'</a></span>';
// 				}else if($mapa->idTipoPosicao == 2){
// 					$impressaoMapa .= '<span class="instrutor" style="' . $mapa->txtStyle . '"><img class="imagem-instrutor" src="' . assets_url('img/site/'. $mapa->txtImagemInstrutor) . '"/><h6 class="nome-instrutor">' .$mapa->txtPrimeiroNome.'</h6></span>';
//                 }else if($mapa->idTipoPosicao == 6){
//                     $impressaoMapa .= '<span class="' . $mapa->txtClass . '" style="' . $mapa->txtStyle . '"><i class="si si-wrench"></i></span>';
//                 }else if($mapa->idTipoPosicao == 7){
//                     $impressaoMapa .= '<span class="' . $mapa->txtClass . '" style="' . $mapa->txtStyle . '"></span>';
// 				}else{
//                     $impressaoMapa .= '<span> </span>';
// 				}
// 			}else{
// 				if(in_array($mapa->id, $arrayMapaBicicletaReservada)){
// 					$impressaoMapa .= '<span class="minha-reserva" style="' . $mapa->txtStyle . '">'. $mapa->txtPosicao.'</span>';
// 				}else{
// 					$impressaoMapa .= '<span class="indisponivel font-s12" style="' . $mapa->txtStyle . '"><a id="bike_'.$mapa->id.'" href="#" class="indisponivel reserva-bike font-s12" onclick="alterarReserva(' . $mapa->id . ',\'' . $retorno_pesquisa->txtNome. '\', \'user\', \''. $mapa->txtPosicao.'\')" >'.$retorno_pesquisa->txtNome.'</a></span>';
// 				}
// 			}
// 		}
// 	}
// 	$impressaoMapa .= '</div>';

// 	return $impressaoMapa;
// }







