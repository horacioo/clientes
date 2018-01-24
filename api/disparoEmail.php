<?php

require_once '../../../../wp-config.php';
require_once '../include/clientes.php';
require_once '../include/Emails.php';

use emailsProcessosEDados\Emails as em;
use Clientes\clientes as cliente;

/* * *****start dos processos******* */
EnviaAniversario();
EnvioAgendado();
/* * ******************************* */

function EnviaAniversario() {
    em::EnvioAniversario();
    $t = em::$texto;
    if (is_array($t)):
        foreach ($t as $t):
            $clientes = cliente::Aniversario();
            if (is_array($clientes)):
                foreach ($clientes as $cl):
                    $email = em::EmailCliente($cl['id']);
                    foreach ($email as $e) {
                        enviaEmail($t['titulo'], $t['conteudo'], $e['email'], $clientes[0]['nome']);
                        salvaDados($cl['id'], $e['id'], $t['id'], '1');
                    }
                endforeach;
            endif;
        endforeach;
    endif;
}










function EnvioAgendado() {
    $textos = em::EnvioAgendado();
    if (is_array($textos)):
        foreach ($textos as $t):
            /*
              echo"<br>" . $t['id'];
              echo"<br>" . $t['titulo'];
              echo"<br>" . $t['conteudo'];
             */

           $clientes = cliente::ClientesEnvioEmail();
           //print_r($clientes);
        endforeach;
    endif;
}










function enviaEmail($titulo = '', $conteudo = '', $email = '', $nome = '') {
    $to      = $email;
    $subject = $titulo;
    $content = Reconstroi($conteudo, $nome);
    $headers = array('Content-Type: text/html; charset=UTF-8');
    $status  = wp_mail($to, $subject, $content, $headers);
}










function Reconstroi($conteudo = '', $nome = '') {
    $nomeArray = explode(" ", $nome);
    $conteudo  = str_replace("%nome%", $nomeArray[0], $conteudo);
    return $conteudo;
}










function salvaDados($cliente = '', $email = '', $texto = '', $tipoEmail = '') {
    global $wpdb;
    $insert = "insert into `logemail`(cliente,email,texto,tipoEmail)values(" . $cliente . "," . $email . "," . $texto . "," . $tipoEmail . ")";
    $wpdb->query($insert);
}









