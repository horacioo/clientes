<?php

require_once 'DataBase.php';
require_once 'form.php';

use FormulariosHTml\htmlRender as us;
use emailsProcessosEDados\Emails as em;

function entradaForm($atts) {


    if (isset($atts)) {

        $entrada1 = $atts['dados'];
        $entrada  = $_POST[$entrada1];
        if (isset($entrada)) {

            us::$entrada      = $entrada1;
            us::$dadosCliente = $entrada;
            us::$locate       = ['nome', 'ip'];
            us::SalvaClientes();
            us::SalvaEmail();
            us::SalvaTelefone();
            us::clientesemail();
            us::clientestelefone();
            us::contato();
            $retorno          = "";
            $Chaves           = array_keys($entrada);
            foreach ($Chaves as $c):
                $retorno .= "<p>";
                if (is_array($entrada[$c])) {
                    foreach ($entrada[$c] as $x): {
                            $retorno .= $c . ":" . $x;
                        }
                    endforeach;
                } else {
                    $retorno .= $c . ":" . $entrada[$c];
                }
                $retorno .= "</p>";
            endforeach;
            us::$DadosForm = $retorno;
        }
    }

    Resposta();
}





function Resposta() {

    global $wpdb;
    $sel = "SELECT ct.id as idContato ,cl.nome,e.email 
FROM `contato` as ct
inner join clientes as cl on cl.id = ct.cliente
inner join clientesemail as ce on ce.clientes = ct.cliente
inner join email as e on e.id = ce.email
WHERE ct.primeiroContato=0";

    /*     * ****************************************** */
    ///echo "<hr>$sel<hr>";
    $dados = $wpdb->get_results($sel, ARRAY_A);
   /// print_r($dados);
    /*     * ***************************************** */
    ///echo "<br>informação -- "; print_r($dados); echo"<br>";
    foreach ($dados as $d):
        Email($d['email'], $d['nome']);
        //exit();
        $wpdb->query("update contato set primeiroContato=1 where id='" . $d['idContato'] . "'");
    endforeach;
}





function Email($email, $nome) {
    em::EnvioAposCadastro();
    $x = em::$texto;

    if (is_array($x)) {
        foreach ($x as $y):
            $to      = $email; //"lanterna_@hotmail.com";
            $subject = $y['titulo'];
            $content = $y['conteudo'];
            $headers = array('Content-Type: text/html; charset=UTF-8');
            $status  = wp_mail($to, $subject, $content, $headers);
        endforeach;
    }
}





function Limpeza($x) {
    $x = strip_tags($x);
    $x = trim($x);
    return $x;
}




