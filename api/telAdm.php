<?php

use Planet1\telefone;

require_once '../../../../wp-config.php';

global $wpdb;


if ($_GET['dados']):



    $dados = $_GET['dados'];


    $x = base64_decode($dados);
    $x = json_decode($x);
    //$z = (array) $x;

    $comando  = $x->comando;
    $telefone = $x->telefone;
    $id       = $x->id_telefone;
    $cliente  = $x->cliente;



    function Lista() {
        global $cliente;
        telefone::$id_cliente = $cliente;
        echo json_encode(telefone::Telefone_do_cliente());
    }



    function Atualiza() {
        global $telefone;
        global $id;
        telefone::$dados_entrada = array("telefone" => $telefone, "id" => $id);
        telefone::Update();
        lista();
    }



    function desassociar() {
        global $wpdb;
        global $cliente;
        global $id;
        $del = "delete from `clientestelefone` where clientes='$cliente' and telefone = $id";
        $wpdb->query($del);
        lista();
    }



    function Criar() {
        global $telefone;
        global $cliente;
        telefone::$dados_entrada=array("telefone"=>$telefone);
        telefone::$id_cliente=$cliente;
        telefone::Create();
        Lista();
    }



    switch ($comando) {
        case"editar": Atualiza();
            break;
        case"deletar": desassociar();
            break;
        case"lista": lista();
            break;
        case"salva":Criar();
            break;
    }

    
    
endif;

