<?php

require_once '../../../../wp-config.php';
require_once '../include/clientes.php';
require_once '../include/Emails.php';
require_once '../include/grupos.php';

use emailsProcessosEDados\Emails as em;
use Clientes\clientes as cliente;
use Grupos\grupos as gr;

/* * *****start dos processos******* */
EnviaAniversario();
sleep(1);
EnvioAgendado();
sleep(1);
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
                            /******************************************************** */
                            $passa = VerificaGrupos($c['id'], $t['id']);
                            if ($passa === TRUE) {
                                exit("<hr>beleza, passa e envia email<hr>");
                                $res = enviaEmail($t['titulo'], $t['conteudo'], $e['email'], $c['nome']);
                                salvaDados($c['id'], $e['id'], $t['id'], $tipo, $res);
                            }
                            else
                            {echo "cliente não pertence ao grupo";}
                            /****************************************************** */
                        endforeach;
                    endif;
                endforeach;
            endif;
        }
    endif;
}





function VerificaGrupos($cliente, $idTexto) {
    $pessoasGRupos = gr::gruposClientes($idTexto);
    if (is_array($pessoasGRupos)) {
        if (in_array($cliente, $pessoasGRupos)) {
            return TRUE;
        } else {
            return FALSE;
        }
    } else {
        return TRUE;
    }
}





function EnvioAgendado() {
    $clientes = cliente::ClientesEnvioEmail();
    $texto    = em::EnvioAgendado();
    if (is_array($clientes)):
        foreach ($clientes as $c):
            $email = em::EmailCliente($c['id']);
            if (is_array($email)):
                foreach ($email as $e):
                    if (is_array($texto)) {
                        foreach ($texto as $t):
                            if (em::$envia == 1):
                                 /******************************************************** */
                            $passa = VerificaGrupos($c['id'], $t['id']);
                            if ($passa === TRUE) {
                                exit("<hr>beleza, passa e envia email<hr>");
                                $res = enviaEmail($t['titulo'], $t['conteudo'], $e['email'], $c['nome']);
                                salvaDados($c['id'], $e['id'], $t['id'], $tipo, $res);
                            }
                            else
                            {echo "cliente não pertence ao grupo";}
                            /****************************************************** */
                            endif;
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

    $headers[] = 'Content-Type: text/html; charset=UTF-8';
    //$headers[] = 'Content-Type: text; charset=UTF-8';
    $headers[] = 'From: Regisepenna corretora de seguros <contato@regisepennaseguros.com.br>';
    $headers[] = 'Reply-To: Regis e Penna corretora de seguros <contato@regisepennaseguros.com.br>';
    /*

      $headers [] = "Reply-To: Regis e Penna corretora de seguros <contato@regisepennaseguros.com.br>\r\n";
      $headers [] = "Return-Path: contato@regisepennaseguros.com.br\r\n";
      $headers [] = "MIME-Version: 1.0\r\n";
      $headers [] = "X-Priority: 3\r\n";
      $headers [] = "X-Mailer: PHP" . phpversion() . "\r\n";
     */

    $status = wp_mail($to, $subject, $content, $headers);
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
    $insert = "insert into `logemail`(cliente,email,texto,tipoEmail,resultado)values(" . $cliente . "," . $email . "," . $texto . "," . $tipoEmail . "," . $res . ")";
    //echo "<br><br>$insert<br><br>";
    $wpdb->query($insert);
}




