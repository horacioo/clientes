<?php

require_once '../config.php';
require_once '../../../../wp-config.php';
require_once '../include/clientes.php';
require_once '../include/Emails.php';
require_once '../include/grupos.php';

use emailsProcessosEDados\Emails as em;
use Clientes\clientes as cliente;
use Grupos\grupos as gr;


/* * *****start dos processos******* */
exit("teste");
EnviaAniversario();
/* * ******************************* */
function EnviaAniversario() {
    $clientes = cliente::Aniversario();
    $textos   = em::EnvioAniversario();
    $textos   = em::$texto;
    $tipo     = 1;
    if (is_array($clientes)):
        foreach ($clientes as $c) {
            $email = em::EmailCliente($c['id']);
            if (is_array($email)):
                foreach ($email as $e):
                    if (is_array($textos)):
                        foreach ($textos as $t):
                            /*                             * ****************************************************** */
                            $res = enviaEmail($c['nome'] . ", " . $t['titulo'], $t['conteudo'], $e['email'], $c['nome']);
                            salvaDados($c['id'], $e['id'], $t['id'], $tipo, $res);
                            /*                             * ****************************************************** */
                        endforeach;
                    endif;
                endforeach;
            endif;
        }
    endif;
}


function enviaEmail($titulo = '', $conteudo = '', $email = '', $nome = '') {
    $to      = $email;
    $subject = $titulo;
    $content = Reconstroi($conteudo, $nome);
    $headers = "MIME-Version: 1.1\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8 \r\n";
    $headers .= "From: Regisepenna corretora de seguros <contato@regisepennaseguros.com.br>  \r\n"; // remetente
    $headers .= 'Reply-To: Regis e Penna corretora de seguros <contato@regisepennaseguros.com.br>';
    $headers .= "Return-Path: contato@regisepennaseguros.com.br  \r\n"; // return-path
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "X-Priority: 3\r\n";
    $headers .= "X-Mailer: PHP" . phpversion() . "\r\n";
    $status  = mail($to, $subject, $content, $headers);
    print_r($status);
    if ($status == TRUE) {
        return 1;
    } else {
        return 0;
        echo"deu erro no envio do email " . $status;
    }
}





function Reconstroi($conteudo = '', $nome = '') {
    $nomeArray = explode(" ", $nome);
    $conteudo  = str_replace("%nome%", $nomeArray[0], $conteudo);
    return $conteudo;
}





function salvaDados($cliente = '', $email = '', $texto = '', $tipoEmail = '', $res = '') {
    global $wpdb;
    global $espera;
    $insert = "insert into `logemail`(cliente,email,texto,tipoEmail,resultado)values(" . $cliente . "," . $email . "," . $texto . "," . $tipoEmail . "," . $res . ")";
    $wpdb->query($insert);
}




