<?php

require_once 'DataBase.php';
require_once 'form.php';

use FormulariosHTml\htmlRender as us;

function entradaForm($atts) {
    $entrada1 = $atts['dados'];
    $entrada  = $_POST[$entrada1];
    if (isset($entrada)){
        us::$locate=['ip'];
        us::$entrada      = $entrada1;
        us::$dadosCliente = $entrada;
        us::SalvaClientes();
        us::SalvaEmail();
        us::SalvaTelefone();
        us::clientesemail();
        us::clientestelefone();
        $retorno = "";
        $Chaves = array_keys($entrada);
        foreach ($Chaves as $c):
            $retorno .= "<p>";
            if (is_array($entrada[$c])){
                foreach ($entrada[$c] as $x): {
                        $retorno .= $c . ":" . $x;
                    }
                endforeach;
            } else{
                $retorno .= $c . ":" . $entrada[$c];
            }
            $retorno .= "</p>";
        endforeach;
        echo $retorno;
        Resposta();
    }
}


function Resposta() {
    print_r(us::$dadosCliente);
}





function Limpeza($x) {
    return $x;
}




