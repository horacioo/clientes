<?php

require_once '../../../../wp-config.php';
require_once '../include/clientes.php';
require_once '../include/Emails.php';

use emailsProcessosEDados\Emails as em;
use Clientes\clientes as cliente;

/* * *****start dos processos******* */
EnviaAniversario();
sleep(10);
EnvioAgendado();
sleep(10);
/* * ******************************* */

function EnviaAniversario() {



    $clientes = cliente::Aniversario();
    $textos   = em::EnvioAniversario();
    $textos   = em::$texto;
    $tipo     = 1;



    if (is_array($clientes)):
        foreach ($clientes as $c) {
            //echo"<hr> cliente " . $c['nome'];
            $email = em::EmailCliente($c['id']);
            if (is_array($email)):
                foreach ($email as $e):
                    if (is_array($textos)):
                        foreach ($textos as $t):
                            $res = enviaEmail($t['titulo'], $t['conteudo'], $e['email'], $c['nome']);
                            //echo "resuultado = $res";
                            salvaDados($c['id'], $e['id'], $t['id'], $tipo, $res);
                        endforeach;
                    endif;
                endforeach;
            endif;
        }
    endif;
}





function EnvioAgendado() {
    $clientes = cliente::ClientesEnvioEmail();
    $texto    = em::EnvioAgendado();
    if (is_array($clientes)):
        foreach ($clientes as $c):
            $email = em::EmailCliente($c['id']);
            if (is_array($email)):
                foreach ($email as $e):
                    print_r($e);
                    if (is_array($texto)){
                        foreach ($texto as $t):
                            $res = enviaEmail($t['titulo'], $t['conteudo'], $e['email'], $c['nome']);
                            salvaDados($c['id'], $e['id'], $t['id'], 3, $res);
                        endforeach;
                     }
                endforeach;
            endif;
        endforeach;
    endif;
}





function enviaEmail($titulo = '', $conteudo = '', $email = '', $nome = '') {
    $to      = $email;
    $subject = $titulo;
    $content = Reconstroi($conteudo, $nome);

    //$headers[] = 'Content-Type: text/html; charset=UTF-8';
    $headers[] = 'Content-Type: text; charset=UTF-8';
    $headers[] = 'From: Regisepenna corretora de seguros <contato@regisepennaseguros.com.br>';
    $headers[] = 'Reply-To: Regis e Penna corretora de seguros <contato@regisepennaseguros.com.br>';
    /*
      $headers [] = "From: Regisepenna corretora de seguros <contato@regisepennaseguros.com.br>\r\n";
      $headers [] = "Reply-To: Regis e Penna corretora de seguros <contato@regisepennaseguros.com.br>\r\n";
      $headers [] = "Return-Path: contato@regisepennaseguros.com.br\r\n";
      $headers [] = "MIME-Version: 1.0\r\n";
      $headers [] = "Content-Type: text/html; charset=UTF-8\r\n";
      $headers [] = "X-Priority: 3\r\n";
      $headers [] = "X-Mailer: PHP" . phpversion() . "\r\n";
     */

    $status = wp_mail($to, $subject, $content, $headers);
    if ($status == TRUE){
        return 1;
    } else{
        return 0;
        echo"deu erro no envio do email " . $status;
    }//return var_dump($status);
}





function Reconstroi($conteudo = '', $nome = '') {
    $nomeArray = explode(" ", $nome);
    $conteudo  = str_replace("%nome%", $nomeArray[0], $conteudo);
    return $conteudo;
}





function salvaDados($cliente = '', $email = '', $texto = '', $tipoEmail = '', $res = '') {
    global $wpdb;
    $insert = "insert into `logemail`(cliente,email,texto,tipoEmail,resultado)values(" . $cliente . "," . $email . "," . $texto . "," . $tipoEmail . "," . $res . ")";
    //echo "<br><br>$insert<br><br>";
    $wpdb->query($insert);
}



