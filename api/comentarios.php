<?php

header('Access-Control-Allow-Origin: *');
require_once '../../../../wp-config.php';

use Planet1\DataBase;
use Planet1\comentario;

if (!empty($_GET['cliente'])):

    $cliente    = $_GET['cliente'];
    $acao       = $_GET['acao'];
    $comentario = $_GET['comentario'];

    comentario::$id_cliente = $cliente;



    function cadastra() {
        
        global $comentario;
        
        comentario::$postadoPor = 25;
        comentario::$comentario = $comentario;
        comentario::SalvaComentario();

        $comentarios = comentario::ComentariosDoCliente();
        echo json_encode($comentarios);
    }



    function lista() {
        $comentarios = comentario::ComentariosDoCliente();
        echo json_encode($comentarios);
    }



    switch ($acao) {
        case "lista": lista();
            break;
        case "salva": cadastra();
            break;
    }




    
    
    
endif;