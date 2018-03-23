<?php

use Planet1\produto as pr;

header('Access-Control-Allow-Origin: *');

require_once '../../../../wp-config.php';

//require "../include/DataBase.php";
//require "../include/produto.php";




if (isset($_GET['dados'])):

    $dados   = $_GET['dados'];
    $entrada = $_GET['entrada'];
    $produto = $_GET['produto'];


    function detalhe() {
        global $produto;
        pr::$id_produto = $produto;
        echo json_encode(pr::detalheProduto());
    }

    function excluir(){
        global $produto;
        pr::$id_produto = $produto;
        pr::Exclude();
    }
    

    switch ($entrada):
        case 1: echo"entrada inicial 1"; break;
        case 2: detalhe(); break;
        case 3: excluir(); break;
    endswitch;



    



       
            
endif;