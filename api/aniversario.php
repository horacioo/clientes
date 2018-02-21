<?php

require_once '../config.php';
require_once '../../../../wp-config.php';
require_once '../include/clientes.php';
require_once '../include/Emails.php';
require_once '../include/grupos.php';

use emailsProcessosEDados\Emails as em;
use Clientes\clientes as cliente;
use Grupos\grupos as gr;



em::$Email_Return_Path  = "contato@regisepennaseguros.com.br";
em::$Email_from         = "contato@regisepennaseguros.com.br";
em::$Email_from_name    = "Regisepenna corretora de seguros";
em::$Email_reply_to     = "contato@regisepennaseguros.com.br";
em::$Email_replyto_name = "Regis e Penna corretora de seguros";


EnviaAniversario();


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
