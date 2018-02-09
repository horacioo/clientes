<?php

namespace importacao;

require_once '../include/clientes.php';

use Clientes\clientes as cl;
use MeuBancoDeDados\DataBase as db;

class importacao
    {
    /*     * *aqui vc vai informar um array com o endereço do arquivo e os campos que deve acessar, também dentro de um array*** */

    public static $dados;
    public static $registro;

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

                $registro       = array_combine($cabecalho, $linha);
                self::$registro = $registro;
                self::CorrigeArray();
                ///$chaves         = array_keys($registro);



                if (!empty($registro['NomeSegurado'])) {
                    /*                     * ************************************** */
                    db::$array            = NULL;
                    /*                     * ************************************** */
                    self::salvaEstadoCivil();
                    /*                     * ************************************** */
                    self::salvaDocumento();
                    /*                     * ************************************** */
                    self::salvaClientes();
                    /*                     * *********************************************** */
                    self::SalvaEstado();
                    /*                     * *********************************************** */
                    self::SalvaCidade();
                    /*                     * *********************************************** */
                    self::SalvaEmail();
                    /*                     * *********************************************** */
                    self::salvaTelefone();
                    /*                     * *********************************************** */
                    self::salvaEndereco();
                    /*                     * *********************************************** */
                    self::salvaProduto();
                    /*                     * *********************************************** */
                    $contagem++;
                    $_SESSION['contagem'] = $contagem;

                    ///echo "<br>$contagem";
                    ////if ($contagem >= 2) {    exit("<br>");  }

                    /*                     * ********cliente********* */
                }
            }
            fclose($f);
        }
        return new importacao;
    }










    private static function salvaProduto($array = "") {

        $dados      = self::$dados['componente']['produto'];
        db::$tabela = "produtos";
        db::$campos = ['apelido', 'produto'];


        if (is_array($dados)) {
            foreach ($dados as $d):
                if (is_array($d)) {
                    echo"é array, novo foreach - - ";
                    print_r($d);
                } else {

                    $x = strpos(self::$registro[$d], "/");
                    if ($x > 0) {
                        $x = explode("/", self::$registro[$d]);
                        foreach ($x as $x):
                            $x = strtolower($x);
                            db::Salva(array("produto" => self::LimpezaDB($x), "apelido" => self::LimpezaDB($x)));
                        endforeach;
                    } else {
                        db::Salva(array("produto" => self::LimpezaDB(self::$registro[$d]), "apelido" => self::LimpezaDB(self::$registro[$d])));
                    }
                }
            endforeach;
        }


        $cliente  = db::$array['clientes'][0];
        $produtos = db::$array['produtos'];

        foreach ($produtos as $p):
            db::$tabela = "clientesprodutos";
            db::$campos = ['clientes', 'produtos'];
            $array      = array("produtos" => $p, "clientes" => $cliente);
            db::Salva($array);
        endforeach;
    }










    private static function salvaEndereco() {

        $dados      = self::$dados['componente']['endereco'];
        db::$tabela = "endereco";
        db::$campos = ['cliente', 'endereco', 'numero', 'complemento', 'cep', 'bairro', 'cidade', 'estado'];
        foreach ($dados as $d):
            if (is_array($d)) {
                $laco                = 1;
                $endereco['cliente'] = db::$array['clientes'][0];
                foreach ($d as $d):
                    $endereco[db::$campos[$laco]] = self::$registro[$d];
                    $laco++;
                endforeach;
                $endereco['cidade'] = db::$array['cidade'][0];
                $endereco['estado'] = db::$array['estado'][0];

                if (!empty($endereco['endereco'])) {
                    db::Salva($endereco);
                }
            } else {
                echo "<br>não salvo";
                echo $d;
            }
        endforeach;
    }










    private static function salvaTelefone() {
        $dados      = self::$dados['componente']['telefone'];
        db::$tabela = "telefone";
        db::$campos = ['ddd', 'telefone'];
        foreach ($dados as $x):
            if (is_array($x)) {
                $ddd      = self::$registro[$x[0]];
                $telefone = str_replace(array("-"), "", self::$registro[$x[1]]);
                if (!empty($telefone)) {
                    db::Salva(array("ddd" => $ddd, "telefone" => $telefone));
                }
            } else {
                db::Salva(array("telefone" => self::$registro[$x]));
            }
        endforeach;

        $cliente  = db::$array;
        $cliente  = $cliente['clientes'][0];
        $telefone = db::$array['telefone'];

        /*         * *************************************************************** */
        db::$tabela = "clientestelefone";
        db::$campos = ['clientes', 'telefone'];
        if (is_array($telefone)) {
            foreach ($telefone as $t):
                db::Salva(array("clientes" => $cliente, "telefone" => $t));
            endforeach;
        }
        //print_r($telefone);
        /*         * *************************************************************** */
    }










    private static function SalvaCidade() {
        db::$tabela = "cidade";
        db::$campos = ['cidade', 'estado'];
        $estado     = db::$array['estado'][0];
        $cidade     = array("cidade" => self::$registro['Cidade'], "estado" => $estado);
        db::Salva($cidade);
    }










    public static function SalvaEstado() {
        db::$tabela = "estado";
        db::$campos = ['estado'];
        $estados    = array("estado" => self::$registro['UF']);
        db::Salva($estados);
    }










    public static function SalvaEmail() {
        db::$tabela = "email";
        db::$campos = ['email'];
        $x          = explode(";", self::$registro['E-mail']);
        $laco       = 0;
        foreach ($x as $x):
            if (!empty($x)):
                db::Salva(array('email' => $x));
                $cliente = db::$array['clientes'][0];
                $email   = db::$array['email'][$laco];
                $dados[] = array("email" => self::LimpezaDB($email), "clientes" => $cliente);
                $laco++;
            endif;
        endforeach;
        self::AssociaEmail($dados);
    }










    private static function AssociaEmail($array = '') {
        db::$tabela = "clientesemail";
        db::$campos = ['clientes', 'email'];
        if (is_array($array)):
            foreach ($array as $x):
                db::Salva($x);
            endforeach;
        endif;
    }










    private static function salvaClientes() {
        db::$tabela                      = clientes;
        db::$campos                      = ['nome', 'cpf', 'tipo_de_pessoa', 'sexo', 'rg', 'estado_civil', 'documento', 'dataNascimento', 'endereco', 'ip'];
        $array_cliente['nome']           = strtolower(self::$registro['NomeSegurado']);
        $array_cliente['tipo_de_pessoa'] = self::$registro['TipoPessoa'];
        $array_cliente['sexo']           = self::$registro['Sexo'];
        $array_cliente['cpf']            = self::$registro['CPF/CNPJ'];
///$array_cliente['rg'] = $registro['NomeSegurado'];
        $array_cliente['dataNascimento'] = date("Y-m-d", strtotime(self::DataAniversario(self::$registro['Data Nascimento'])));
        $array_cliente['documento']      = db::$array['documento'][0];
        $array_cliente['estado_civil']   = db::$array['estado_civil'][0];
        $array_cliente['ip']             = $_SERVER['REMOTE_ADDR'];
        db::Salva($array_cliente);
    }










    private static function salvaDocumento() {
        db::$tabela        = "documento";
        db::$campos        = ["documento"];
        $docs['documento'] = self::sanitizeString(self::$registro['Susep']);
        db::Salva($docs);
    }










    private static function salvaEstadoCivil() {
        db::$tabela            = "estado_civil";
        db::$campos            = ["estado_civil"];
        $dados['estado_civil'] = self::sanitizeString(self::LimpezaDB(self::$registro['Estado Civil']));
        db::Salva($dados);
    }










    private static function DataAniversario($data = '') {
        return str_replace("/", "-", $data);
    }










    private static function sanitizeString($str) {
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










    public static function LimpezaDB($info) {
        $x = trim($info);
        $x = strtolower($x);
        return $x;
    }










    public static function CorrigeArray() {
        $x        = self::$registro;
        $chaves   = array_keys($x);
        $ponteiro = -1;
        foreach ($chaves as $c):
            $ponteiro++;
            $newChave             = utf8_encode($c);
            //echo "<li>$newChave ----  ".self::$registro[$c]."</li>";
            $newArray [$newChave] = self::LimpezaDB(self::$registro[$c]);
        endforeach;
        self::$registro = $newArray;
    }










    }
