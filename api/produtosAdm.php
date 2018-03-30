<?php

use Planet1\produto;

require_once '../../../../wp-config.php';
global $wpdb;

if ($_GET['dados']):

    $dados = $_GET['dados'];
    $x     = base64_decode($dados);
    $x     = json_decode($x);


    $comando  = $x->comando;
    $produto  = $x->produto;
    $id       = $x->id_telefone;
    $cliente  = $x->cliente;
    $comissao = $x->comissao;
    $valor    = $x->valor;
    $ativo    = $x->ativo;
    $data     = $x->data;



    function lista() {
        global $cliente;
        produto::$id_cliente = $cliente;
        echo json_encode(produto::ProdutoDoCliente());
    }



    function AssociaUmCliente() {
        global $cliente;
        global $produto;
        global $valor;
        global $comissao;
        global $ativo;

        $dados = array("produto" => $produto, "cliente" => $cliente, "valor" => $valor, "comissao" => $comissao, "ativo" => 1);

        produto::$id_cliente   = $cliente;
        produto::$dadosEntrada = $dados;
        produto::$DeletaOutros = FALSE;
        produto::AssociacaoDeClientes();
        lista();
    }



    function desassocia() {
        global $x;
        global $cliente;
        global $produto;
        global $valor;
        global $comissao;
        global $ativo;
        global $wpdb;
        global $data;
        $sel = "delete from `clientesprodutos` where produtos='$produto' and data='$data' and clientes='$cliente' ";
        $wpdb->query($sel);
        lista();
    }



    function listaDeProdutos() {
        produto::$tabela = "produtos";
        echo json_encode(produto::ListaProdutos());
    }



    switch ($comando):
        case "listar": lista();
            break;
        case "associa":AssociaUmCliente();
            break;
        case"deletar":desassocia();
            break;
        case"listaDeProdutos":listaDeProdutos();
            break;
    endswitch;

    
    endif;