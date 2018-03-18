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

        ////if (isset($_POST['token'])) {
        //$token  = $_POST['token'];
        //$tokenx = token::VerificaToken();
        /////if (!empty($tokenx)) {/////////////////////////////////
        //criar uma sessao para impedir novos cadastros repetidos
        if (isset($_SESSION['form_entrada_dados'])) {
            ///echo"aguarde um momento!! cadastro já foi emmitido";
        } else {
            ///echo "vamos cadastrar seus dados agora!";
        }

        $_SESSION['form_entrada_dados'] = time();
        $dados                          = $_POST['dados'];
        $chaves                         = array_keys($dados);
        /*         * ******************************* */
        foreach ($chaves as $c):
            if ($c === "clientes") {
                cl::$dados_entrada = $dados;
                cl::create();
            }
            /*             * ******************************* */
            if ($c === "email") {
                foreach ($dados['email']['email'] as $e):
                    if (!empty($e)):
                        em::$entradaDados = array("email" => $e);
                        em::$id_cliente   = cl::$IdCliente;
                        em::Create();
                    endif;
                endforeach;
            }
            /*             * ******************************* */
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
        /*         * *************** */


        /*         * * */
        EnviaADministrador();
    /*     * * */
    ///////////}
    /* else {

      exit("token inválido ou inexistente");
      } */
    ////////}
    endif;
}



function EnviaADministrador() {
    $informacao = "";
    $dados      = $_POST['dados'];
    $chaves     = array_keys($dados);


    foreach ($chaves as $c):
        $informacao .= "\n <br>" . $c . "= ";
        if (is_array($dados[$c])) {
            foreach ($dados[$c] as $x):
                if (!is_array($x)) {
                    $informacao .= " " . $x . "<br>";
                } else {
                    foreach ($x as $z):
                        $informacao .= " " . $z . "<br>";
                    endforeach;
                }
            endforeach;
        }else {
            $informacao .= "" . $dados[$c] . "<br>";
        }
    endforeach;

    $informacao .= "entrada do cliente as " . date("d/m/Y H:i:s") . "";

    $email_dados         = bloginfo('admin_email');
    em::$Email_from      = "contato@regisepennaseguros.com.br";
    em::$Email_from_name = "Regis e penna ";
    em::$titulo          = "solicitação de contato";
    em::$conteudo_email  = $informacao;
    em::$email           = "lanterna_@hotmail.com"; //$email_dados;
    em::DisparaEmail();
}



function Limpeza($x) {
    $x = strip_tags($x);
    $x = trim($x);
    return $x;
}


