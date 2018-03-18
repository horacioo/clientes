<?php

require_once 'DataBase.php';
require_once 'form.php';

use Planet1\htmlRender as us; //use FormulariosHTml\htmlRender as us;
use Planet1\Emails as em; //use emailsProcessosEDados\Emails as em;
use Planet1\clientes as cl;
use Planet1\telefone as tel;
use Planet1\token;



function entradaForm() {
    if (isset($_POST['dados'])):

        if (isset($_POST['token'])) {

            $token  = $_POST['token'];
            $tokenx = token::VerificaToken();

            if (!empty($tokenx)) {
                //criar uma sessao para impedir novos cadastros repetidos
                if (isset($_SESSION['form_entrada_dados'])) {
                    ///echo"aguarde um momento!! cadastro já foi emmitido";
                } else {
                    ///echo "vamos cadastrar seus dados agora!";
                }

                $_SESSION['form_entrada_dados'] = time();
                $dados                          = $_POST['dados'];
                $chaves                         = array_keys($dados);
                /*                 * ******************************* */
                foreach ($chaves as $c):
                    if ($c === "clientes") {
                        cl::$dados_entrada = $dados;
                        cl::create();
                    }
                    /*                     * ******************************* */
                    if ($c === "email") {
                        foreach ($dados['email']['email'] as $e):
                            if (!empty($e)):
                                em::$entradaDados = array("email" => $e);
                                em::$id_cliente   = cl::$IdCliente;
                                em::Create();
                            endif;
                        endforeach;
                    }
                    /*                     * ******************************* */
                    if ($c === "telefone") {
                        foreach ($dados['telefone']['telefone'] as $t):
                            if (!empty($t)):
                                tel::$dados_entrada = array("telefone" => $t);
                                tel::$id_cliente    = cl::$IdCliente;
                                tel::Create();
                            endif;
                        endforeach;
                    }
                endforeach;
                /*                 * *************** */
            }
            else {
                exit("token inválido ou inexistente");
            }
        }
    endif;
}




function Limpeza($x) {
    $x = strip_tags($x);
    $x = trim($x);
    return $x;
}


