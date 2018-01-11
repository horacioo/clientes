<?php

require_once 'DataBase.php';
require_once 'form.php';

use FormulariosHTml\htmlRender as us;

function entradaForm($atts) {
    
    if (isset($atts)){

        $entrada1 = $atts['dados'];
        $entrada  = $_POST[$entrada1];
        if (isset($entrada)){

            us::$entrada      = $entrada1;
            us::$dadosCliente = $entrada;

            us::$locate = ['nome', 'ip'];
            us::SalvaClientes();
            us::SalvaEmail();
            us::SalvaTelefone();
            us::clientesemail();
            us::clientestelefone();
            $retorno    = "";
            $Chaves     = array_keys($entrada);
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
            us::$DadosForm = $retorno;
            
    }
        
}
echo "<p> linha X";///Resposta();
}





function atendimento() {
    
}





function Resposta() {
    $to      = "lanterna_@hotmail.com";
    $subject = "teste";
    $content = us::$DadosForm;
    $status  = wp_mail($to, $subject, $content);
    //var_dump($status);
}





function Limpeza($x) {
    $x = strip_tags($x);
    $x = trim($x);
    return $x;
}





function Contato() {
    
}




