<?php

namespace importacao;

require_once '../include/clientes.php';

use Clientes\clientes as cl;
use MeuBancoDeDados\DataBase as db;

class importacao
    {
    /*     * *aqui vc vai informar um array com o endereço do arquivo e os campos que deve acessar, também dentro de um array*** */

    public static $dados;

    public static function abre_arquivo() {
        $arquivo       = self::$dados['endereco'];
        $camposCliente = cl::$campos;
        $delimitador   = ',';
        $cerca         = '"';
        $f             = fopen($arquivo, 'r');
        if ($f) {
            $cabecalho = fgetcsv($f, 0, $delimitador, $cerca);


            $contagem = 0;
            while (!feof($f)) {

                $linha = fgetcsv($f, 0, $delimitador, $cerca);
                if (!$linha) {
                    continue;
                }

                $registro = array_combine($cabecalho, $linha);
                $chaves   = array_keys($registro);


                $telefone['residencial'] = $registro['DDD'] . " - " . $registro['TelefoneResidencial'];
                $telefone['comercial'] = $registro['DDD'] . " - " . $registro['TelefoneComercial'];
                $telefone['celular'] = $registro['DDD'] . " - " . $registro['TelefoneCelular'];
               

                /*                 * ********cliente********* */

                /*                 * ************************************************ */
                /*                 * ************************************************ */
                /*                 * ************************************************ */
                //////processos de cadastros principais e periféricos
                foreach ($chaves as $c):
                    if (in_array($c, $camposCliente)):
                        $cliente;
                        if ($c == "dataNascimento") {
                            $cliente[$c] = date("Y-m-d", strtotime($registro[$c])); //dataNascimento
                        } else {
                            $cliente[$c] = strtolower($registro[$c]);
                        }
                    endif;




                endforeach;

                db::$array               = NULL;
                ////////////////////////
                db::$tabela              = "estado_civil";
                db::$campos              = ['estado_civil'];
                db::Salva(array('estado_civil' => $registro['estado_civil']));
                ////////////////////////
                db::$tabela              = 'clientes';
                db::$campos              = cl::$campos;
                $cliente['estado_civil'] = db::$array['estado_civil'][0];
                db::Salva($cliente); //($cliente);

                $cliente_id = db::$array['clientes'][0];



                /*                 * ********************************************** */
                /*                 * ********************************************** */
                //telefone
                //print_r($registro); echo"<hr><br>";// [DDD] => 13 [TelefoneResidencial]
                echo "<br>";
                print_r($telefone);
                echo "<br>";

                /*                 * ********************************************** */
                /*                 * ********************************************** */
                //email
                db::$tabela = "email";
                db::$campos = ['email'];
                $email      = array();
                $emails     = explode(";", $registro['E-mail']);
                if (!empty($emails)):
                    foreach ($emails as $e):
                        if (!empty($e)):
                            //echo $e;
                            db::Salva(array("email" => $e));
                        endif;
                    endforeach;
                endif;
                /*                 * ********************************************** */
                /*                 * ********************************************** */



                $meusEmails = db::$array['email'];
                $novaArray  = array();
                if (!empty($meusEmails)):
                    db::$tabela = "clientesemail";
                    db::$campos = ['clientes', 'email'];
                    foreach ($meusEmails as $Ee):
                        $novaArray['email']    = $Ee;
                        $novaArray['clientes'] = $cliente_id;
                        db::Salva($novaArray);
                    endforeach;
                endif;


                /*                 * *********************************************** */
                /*                 * *********************************************** */
                /*                 * **************** */


                /*                 * *********************************************** */
                /*                 * *********************************************** */
                /*                 * **************** */



                $contagem++;
                $_SESSION['contagem'] = $contagem;
                if ($contagem >= 3) {
                    exit("<br>");
                }

                /*                 * ********cliente********* */
            }
            fclose($f);
        }
        return new importacao;
    }










    private function sanitizeString($str) {
        $str = preg_replace('/[áàãâä]/ui', 'a', $str);
        $str = preg_replace('/[éèêë]/ui', 'e', $str);
        $str = preg_replace('/[íìîï]/ui', 'i', $str);
        $str = preg_replace('/[óòõôö]/ui', 'o', $str);
        $str = preg_replace('/[úùûü]/ui', 'u', $str);
        $str = preg_replace('/[ç]/ui', 'c', $str);
        // $str = preg_replace('/[,(),;:|!"#$%&/=?~^><ªº-]/', '_', $str);
        $str = preg_replace('/[^a-z0-9]/i', '_', $str);
        $str = preg_replace('/_+/', '_', $str); // ideia do Bacco :)
        return $str;
    }










    }
