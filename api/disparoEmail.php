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

em::$Email_Return_Path  = "contato@regisepennaseguros.com.br";
em::$Email_from         = "contato@regisepennaseguros.com.br";
em::$Email_from_name    = "Regisepenna corretora de seguros";
em::$Email_reply_to     = "contato@regisepennaseguros.com.br";
em::$Email_replyto_name = "Regis e Penna corretora de seguros";


$x     = 0;
$total = 30;

echo"<br>". date("H:i:s");

while ($x < $total):

    EnviaAniversario();
    sleep(5);
    EnvioAgendado();
    sleep(5);
    EnvioClientesNovos();
    sleep(5);

    $x++;
    sleep(30);

    echo"<br>processo $x realizado";
endwhile;

echo"<br>". date("H:i:s");




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
                            gr::$grupo_id_cliente = $c['id'];
                            gr::$grupo_id_texto   = $t['id'];
                            gr::VerificaGrupos();
                            if (gr::$grupo_pertence_ao_grupo == 1):
                                /*                                 * ************ */
                                em::$email          = $e['email'];
                                em::$titulo         = $t['titulo'];
                                em::$conteudo_email = $t['conteudo'];
                                em::$nome_cliente   = $c['nome'];
                                em::$id_cliente     = $c['id'];
                                em::$id_email       = $e['id'];
                                em::$id_texto       = $t['id'];
                                em::$tipo_do_email  = $tipo;
                                em::DisparaEmail();
                            /*                             * ******* */
                            endif;
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

                                gr::$grupo_id_cliente = $c['id'];
                                gr::$grupo_id_texto   = $t['id'];
                                gr::VerificaGrupos();

                                if (gr::$grupo_pertence_ao_grupo == 1):
                                    /*                                     * ************ */
                                    em::$email          = $e['email'];
                                    em::$titulo         = $t['titulo'];
                                    em::$conteudo_email = $t['conteudo'];
                                    em::$nome_cliente   = $c['nome'];
                                    em::$id_cliente     = $c['id'];
                                    em::$id_email       = $e['id'];
                                    em::$id_texto       = $t['id'];
                                    em::$tipo_do_email  = 3;
                                    em::DisparaEmail();
                                /*                                 * ******* */
                                endif;

                            endif;
                        endforeach;
                    }
                endforeach;
            endif;
        endforeach;
    endif;
}










/* * quando na administração for informado que o e-mail será enviado após X dias, é esse método que será responsável pelo envio do e-mail */

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
                            $email_cliente        = $mail['email'];
                            $id_email             = $mail['id'];
                            /*                             * ****************************************************** */
                            gr::$grupo_id_cliente = $id_do_cliente;
                            gr::$grupo_id_texto   = $id_do_texto;
                            gr::VerificaGrupos();
                            if (gr::$grupo_pertence_ao_grupo == 1):
                                /*                                 * ************ */
                                em::$email          = $email_cliente;
                                em::$titulo         = $titulo;
                                em::$conteudo_email = $conteudo;
                                em::$nome_cliente   = $nome_do_cliente;
                                em::$id_cliente     = $id_do_cliente;
                                em::$id_email       = $id_email;
                                em::$id_texto       = $id_do_texto;
                                em::$tipo_do_email  = 5;
                                em::DisparaEmail();
                            /*                             * ******* */
                            endif;
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









