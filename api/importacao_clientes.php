<?php

header('Access-Control-Allow-Origin: *');

require_once '../../../../wp-config.php';

$x = require "../include/importacao/importacao.php";

//var_dump($x);

use importacao\importacao as importa;


$dadosxx        = importa::$dados = array('endereco' => 'http://localhost/corretorawp/wp-content/uploads/2018/02/c-to-c.csv');

importa::$dados['componente']['email']    = "E-mail";
importa::$dados['componente']['telefone'] = array(array('DDD', 'TelefoneResidencial'), array('DDD', 'TelefoneComercial'), array('DDD', 'TelefoneCelular'));
importa::$dados['componente']['endereco'] = array(
    array("Endereço", "Nº", "Complemento", "Bairro", "Cidade", "UF"),
    array("Endereço2", "Nº2", "Complemento2", "Bairro2", "Cidade2", "UF2"),
    array("Endereço3", "Nº3", "Complemento3", "Bairro3", "Cidade3", "UF3")
);
importa::$dados['componente']['produto']=array("Ramo");

importa::abre_arquivo();
