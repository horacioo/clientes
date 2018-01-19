<?php

header('Access-Control-Allow-Origin: *');

require_once '../../../../wp-config.php';
$dados = $_REQUEST;

if (is_numeric($dados['param'])){
    retorno($dados);
} elseif (is_string($dados['param'])) {
    Lista($dados);
} elseif (!isset($dados['param'])) {
    Lista($dados);
}

function retorno($dados = '') {
    global $wpdb;
    $query         = "select * from clientes where id='" . $dados['param'] . "'";
    $y             = $wpdb->get_row($query, ARRAY_A);
    $y['email']    = Emails($dados['param']);
    $y['telefone'] = telefone($dados['param']);
    echo json_encode($y);
}





function Emails($cliente = '') {
    global $wpdb;
    $sql = "select ce.email ,em.email from clientesemail as ce left join email as em on em.id = ce.email where clientes = " . $cliente . " ";
    $x   = $wpdb->get_results($sql, ARRAY_A);
    $x[] = "";
    return $x;
}





function telefone($cliente = '') {
    global $wpdb;
    $sql = "select ce.telefone ,tel.telefone
from clientestelefone as ce 
left join telefone as tel on tel.id = ce.telefone 
where clientes =$cliente";
    //echo $sql;
    $x   = $wpdb->get_results($sql, ARRAY_A);
    $x[] = "";
    return $x;
}





function Lista($dados) {

    $nome = $dados['param'];

    if ($nome == "*" )
      {
        $query = "select * from clientes limit 30";

    } else
        {
        $query = "select * from clientes where nome like'%" . $nome . "%' limit 30";
    }
    global $wpdb;

    $y = $wpdb->get_results($query, ARRAY_A);

    echo json_encode($y);
}




