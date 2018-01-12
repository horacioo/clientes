<?php

require_once 'DataBase.php';
require_once 'form.php';

use FormulariosHTml\htmlRender as us;

function entradaForm($atts) {
    $_SESSION['processoCliente'] ++;
    
    echo "<br> contagem ".Contagem();
    
    if(Contagem() === 0){
        
        
        if (isset($atts)){

            $entrada1 = $atts['dados'];
            $entrada  = $_POST[$entrada1];
            if (isset($entrada)){

                us::$entrada      = $entrada1;
                us::$dadosCliente = $entrada;
                us::$locate       = ['nome', 'ip'];
                us::SalvaClientes();
                us::SalvaEmail();
                us::SalvaTelefone();
                us::clientesemail();
                us::clientestelefone();
                $retorno          = "";
                $Chaves           = array_keys($entrada);
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
    
        Resposta();
        echo "<p> linha X";
        print_r($_SESSION['processoCliente']); ///Resposta();
}
}





function Contagem() {
    if(is_null($_SESSION['processoCliente']))
       {
        return 0;
        }
        else{return 1;}
}





function atendimento() {
    
}





function Resposta() {
    if ($_SESSION['processoCliente'] === 0):
        $to                          = "lanterna_@hotmail.com";
        $subject                     = "teste";
        $content                     = us::$DadosForm;
        $status                      = wp_mail($to, $subject, $content);
        $_SESSION['processoCliente'] = 1;
    endif;
}





function Limpeza($x) {
    $x = strip_tags($x);
    $x = trim($x);
    return $x;
}





function Contato() {
    
}




