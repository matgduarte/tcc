<?php 
    require_once('includes/conexao.php');



// Função de coordenadas
$graus = $valor_dado_5;


function obterDirecaoVento($graus) {
    if ($graus >= 0 && $graus < 11.25) return 'Norte';
    if ($graus >= 11.25 && $graus < 33.75) return 'Norte-Nordeste';
    if ($graus >= 33.75 && $graus < 56.25) return 'Nordeste ';
    if ($graus >= 56.25 && $graus < 78.75) return 'Leste-Nordeste';
    if ($graus >= 78.75 && $graus < 101.25) return 'Leste';
    if ($graus >= 101.25 && $graus < 123.75) return 'Leste-Sudeste';
    if ($graus >= 123.75 && $graus < 146.25) return 'Sudeste';
    if ($graus >= 146.25 && $graus < 168.75) return 'Sul-Sudeste';
    if ($graus >= 168.75 && $graus < 191.25) return 'Sul';
    if ($graus >= 191.25 && $graus < 213.75) return 'Sul-Sudoeste';
    if ($graus >= 213.75 && $graus < 236.25) return 'Sudoeste';
    if ($graus >= 236.25 && $graus < 258.75) return 'Oeste-Sudoeste';
    if ($graus >= 258.75 && $graus < 281.25) return 'Oeste';
    if ($graus >= 281.25 && $graus < 303.75) return 'Oeste-Noroeste';
    if ($graus >= 303.75 && $graus < 326.25) return 'Noroeste';
    if ($graus >= 326.25 && $graus < 348.75) return 'Norte-Noroeste';
    if ($graus >= 348.75 && $graus < 360) return 'Norte';
}
$direcao = obterDirecaoVento($graus);



?>