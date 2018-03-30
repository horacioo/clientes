<?php

use Planet1\clientes;

require_once '../../../../wp-config.php';
global $wpdb;

if ($_GET['dados']) {
    $dados = $_GET['dados'];
    $x     = base64_decode($dados);
    $x     = json_decode($x);
  
}