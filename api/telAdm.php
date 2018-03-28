<?php

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

    
    print_r($x);



    function Atualiza() {
        global $telefone;
        global $id;
        global $wpdb;
        $up = "UPDATE `telefone` SET `telefone` = '$telefone' WHERE `telefone`.`id` = 31974; ";
        $wpdb->query($up);
        echo json_encode(array("info" => "333"));
    }



    function desassociar() {
        global $wpdb;
        global $cliente;
        global $id;
        $del = "delete from 'clientestelefone' where clientes='$cliente' and telefone = $id";
        echo "<hr>".$del;
        $wpdb->query($del);
    }



    switch ($comando) {
        case"editar": Atualiza();
            break;
        case"deletar": desassociar();
            break;
    }

    
    
endif;

