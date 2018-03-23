<?php

header('Access-Control-Allow-Origin: *');
require_once '../../../../wp-config.php';

use Planet1\DataBase;
use Planet1\clientes;

$dados = new clientesApi();

echo json_encode($dados->LocalizaCliente()->lista_info);

class clientesApi
    {

    public $cliente_info;
    public $lista_info;



    function VerificaCliente() {
        if (!empty($_GET['cliente'])) {
            $cliente            = $_GET['cliente'];
            $this->cliente_info = $cliente;
        } else {
            $this->cliente_info = "";
        }
        return $this;
    }



    function LocalizaCliente() {
        clientes::$nome   = $this->VerificaCliente()->cliente_info;
        if(strlen($this->cliente_info) > 3){
        clientes::localizaClientes();
        $this->lista_info = clientes::$listaDeClientes;
        return $this;
        }
        else{return NULL;}
    }



    }
