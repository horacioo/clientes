<?php

header('Access-Control-Allow-Origin: *');

require_once '../../../../wp-config.php';

$x = require "../include/importacao/importacao.php";

use importacao\importacao as importa;

$pasta = "C:/xampp/htdocs/CorretoraWP/wp-content/uploads/2018/02/";



$path      = $pasta;
$diretorio = dir($path);
$ponteiro = 0;
while ($arquivo = $diretorio->read()) {
    if ($ponteiro >= 2) {
        echo "<li><a href='" . $path . $arquivo . "'>$ponteiro -- " . $path . $arquivo . "</a><br></li>";
        Upload($path.$arquivo); 
        usleep(30);
    }
    $ponteiro++;
}
$diretorio->close();
















function Upload($arquivo = '') {
    $dadosxx                                  = importa::$dados                           = array('endereco' => $arquivo);
    importa::$dados['componente']['email']    = "E-mail";
    importa::$dados['componente']['telefone'] = array(array('DDD', 'TelefoneResidencial'), array('DDD', 'TelefoneComercial'), array('DDD', 'TelefoneCelular'));
    importa::$dados['componente']['endereco'] = array(
        array("Endereço", "Nº", "Complemento","CEP", "Bairro", "Cidade", "UF"),
        array("Endereço2", "Nº2", "Complemento2","CEP2",  "Bairro2", "Cidade2", "UF2"),
        array("Endereço3", "Nº3", "Complemento3","CEP3",  "Bairro3", "Cidade3", "UF3")
    );
    importa::$dados['componente']['produto']  = array("Ramo");
    importa::abre_arquivo();
    sleep(10);
}









