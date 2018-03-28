<?php

require "../include/Emails.php";
require_once '../../../../wp-config.php';

if (isset($_GET['dados'])):
    $dados = $_GET['dados'];
    $dados = base64_decode($dados);
    $dados = json_decode($dados);


//echo"<hr>";print_r($dados);echo"<hr>";

    $comando = $dados->comando;
    $cliente = $dados->cliente;
    $email   = $dados->email;
    $idEmail = $dados->id;



    function Cadastra() {
        global $email;
        global $cliente;
        
        $X                             = array("email" => $email);
        \Planet1\Emails::$entradaDados = $X;
        \Planet1\Emails::$id_cliente   = $cliente;
        \Planet1\Emails::Create();
        lista();
    }



    function deletar() {
        global $email;
        global $cliente;
        global $idEmail;
        global $wpdb;
        $del = "delete  from `clientesemail` where clientes = '$cliente' and email = '$idEmail'";
        $wpdb->query($del);
        lista();
    }



    function lista() {
        global $cliente;
        Planet1\Emails::$id_cliente = $cliente;
        $x                          = \Planet1\Emails::EmailCliente();
        echo json_encode($x);
    }



    function editar() {
        global $email;
        global $idEmail;
        \Planet1\Emails::$entradaDados = array("id" => $idEmail, "email" => $email);
        \Planet1\Emails::Update();
        lista();
    }



    switch ($comando):
        case'salva':Cadastra();
            break;
        case'listar':lista();
            break;
        case'editar':editar();
            break;
        case'deletar':deletar();
            break;
    endswitch;





endif;