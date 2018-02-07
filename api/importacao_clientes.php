<?php

header('Access-Control-Allow-Origin: *');

require_once '../../../../wp-config.php';

$x = require "../include/importacao/importacao.php";

//var_dump($x);

use importacao\importacao as importa;

$dadosxx        = importa::$dados = array('endereco' => 'http://localhost/corretorawp/wp-content/uploads/2018/02/mini-relatorio-mini-relatorio-1.csv');

importa::$dados['componente']['email'] = "E-mail";
importa::$dados['componente']['telefone'] = array(array('DDD','TelefoneResidencial'),array('DDD','TelefoneComercial'),array('DDD','TelefoneCelular'));
importa::$dados['componente']['endereco'] = array();

importa::abre_arquivo();
