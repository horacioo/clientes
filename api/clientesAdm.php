<?php

use Planet1\clientes;

require_once '../../../../wp-config.php';
global $wpdb;

if ($_GET['dados']) {
    $dados = $_GET['dados'];
    $x     = base64_decode($dados);
    $x     = json_decode($x);

    $comando = $x->comando;
    $cliente = $x->cliente;



    function lista() {
        global $cliente;
        clientes::$nome        = $cliente->nome;
        clientes::$limiteDados = $cliente->id_cliente;
        clientes::localizaClientes();
        echo json_encode(clientes::$listaDeClientes);
    }



    function salva() {
        global $x;
        $dados = abc;
       clientes::$IdCliente= '2';
       //clientes::Update();
        echo json_encode($x);
    }



    switch ($comando) {
        case "pesquisa": lista();
            break;
        case "salva":salva();
            break;
    }
}