<?php

require_once '../config.php';
require_once '../../../../wp-config.php';
require_once '../include/clientes.php';
require_once '../include/Emails.php';
require_once '../include/grupos.php';

use emailsProcessosEDados\Emails as em;
use Clientes\clientes as cliente;
use Grupos\grupos as gr;

$espera = 0;
$pro    = 01;
/* * *****start dos processos******* */
EnviaAniversario();
sleep(10);
EnvioAgendado();
sleep(10);
EnvioClientesNovos();
sleep(10);
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
                            $passa = VerificaGrupos($c['id'], $t['id']);
                            if ($passa === TRUE) {
                                $res = enviaEmail($c['nome'] . ", " . $t['titulo'], $t['conteudo'], $e['email'], $c['nome']);
                                salvaDados($c['id'], $e['id'], $t['id'], $tipo, $res);
                            } else {
                                
                            }
                            /*                             * ****************************************************** */
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
                    if (is_array($texto)) {
                        foreach ($texto as $t):
                            if (em::$envia == 1):
                                /*                                 * ****************************************************** */
                                $passa = VerificaGrupos($c['id'], $t['id']);
                                if ($passa === TRUE) {
                                    $res = enviaEmail($t['titulo'], $t['conteudo'], $e['email'], $c['nome']);
                                    salvaDados($c['id'], $e['id'], $t['id'], $tipo, $res);
                                } else {
                                    ////echo "cliente não pertence ao grupo";
                                }
                            /*                             * ********************************************************* */
                            endif;
                        endforeach;
                    }
                endforeach;
            endif;
        endforeach;
    endif;
}





function EnvioClientesNovos() {
    global $wpdb;
    $sel2  = "SELECT * FROM " . $wpdb->prefix . "postmeta WHERE meta_key = 'diasApos'";
    $dados = $wpdb->get_results($sel2, ARRAY_A);



    foreach ($dados as $d)://estou criando um laço de textos, e dentro dele, chamando os clientes que entraram nessas respectivas datas
        $dias   = $d['meta_value'];
        $textos = em::TextosParaSeremEnviadosAposDias($d['post_id']);
        $tipo   = $textos['metas']['opcaoDeEmail'][0];
        ///echo "<hr>o tipo do texto é  $tipo";
        if ($tipo == 5) {
            $clientes    = cliente::ClientesRecebemEmailsAposDias($dias);
            $id_do_texto = $textos['ID'];
            $conteudo    = $textos['post_content'];
            $titulo      = $textos['post_title'];
            if (!empty($clientes)) {
                foreach ($clientes as $cl):
                    $nome_do_cliente = $cl['nome'];
                    $id_do_cliente   = $cl['id'];
                    if (is_array($cl['email'])):
                        foreach ($cl['email'] as $mail):
                            $email_cliente = $mail['email'];
                            $id_email      = $mail['id'];
                            /*                             * ****************************************************** */
                            $passa         = VerificaGrupos($id_do_cliente, $id_do_texto);
                            if ($passa === TRUE) {
                                $res = enviaEmail($nome_do_cliente . ", " . $titulo, $conteudo, $email_cliente, $nome_do_cliente);
                                salvaDados($id_do_cliente, $id_email, $id_do_texto, 5, $res);
                            } else {
                                
                            }
                        endforeach;
                    endif;
                endforeach;
            }
        } else {
            
        }
        /*         * ******************************************************** */
        $clientes = NULL;

    endforeach;
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





function enviaEmail($titulo = '', $conteudo = '', $email = '', $nome = '') {


    $to      = $email;
    $subject = $titulo;
    $content = Reconstroi($conteudo, $nome);
    /*
      $headers[]  = 'Content-Type: text/html; charset=UTF-8';
      $headers[]  = 'From: Regisepenna corretora de seguros <contato@regisepennaseguros.com.br>';
      $headers[]  = 'Reply-To: Regis e Penna corretora de seguros <contato@regisepennaseguros.com.br>';
      $headers [] = "Return-Path: contato@regisepennaseguros.com.br\r\n";
      $headers [] = "MIME-Version: 1.0\r\n";
      $headers [] = "X-Priority: 3\r\n";
      $headers [] = "X-Mailer: PHP" . phpversion() . "\r\n";
      $status     = wp_mail($to, $subject, $content, $headers);
      print_r($status);
      if ($status == TRUE) {
      return 1;
      } else {
      return 0;
      echo"deu erro no envio do email " . $status;
      }
     */
    $headers = "MIME-Version: 1.1\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8 \r\n";
    $headers .= "From: Regisepenna corretora de seguros <contato@regisepennaseguros.com.br>  \r\n"; // remetente
    $headers .= 'Reply-To: Regis e Penna corretora de seguros <contato@regisepennaseguros.com.br>';
    $headers .= "Return-Path: contato@regisepennaseguros.com.br  \r\n"; // return-path
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "X-Priority: 3\r\n";
    $headers .= "X-Mailer: PHP" . phpversion() . "\r\n";
    $status  = mail($to, $subject, $content, $headers);
    //print_r($status);
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
    sleep($espera);
}







