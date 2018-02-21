<?php

         namespace Planet1;

         use Planet1\DataBase as db;
         use Planet1\Emails as em;
         use Planet1\grupos as gr;

         class clientes {

             static public $campos = ['nome', 'tipo_de_pessoa', 'estado_civil', 'sexo', 'cpf', 'rg', 'dataExpedicao', 'dataNascimento', 'ip', 'entrada', 'documento'];
             static public $cliente;
             static public $IdCliente;
             static $nome;
             static $tipo_de_pessoa;
             static $estado_civil;
             static $sexo;
             static $cpf;
             static $rg;
             static $dataExpedicao;
             static $dataNascimento;
             static $ip;
             static $entrada;
             static $documento;
             static $tabela        = 'clientes';

             public static function Aniversario() {
                 global $wpdb;
                 $sel2    = " select cliente from logemail where month(data)='" . date("m") . "' and day(data)='" . date("d") . "' and year(data)='" . date("Y") . "' and tipoEmail='1'";
                 $Sel     = "SELECT id,nome FROM `clientes` WHERE day(dataNascimento) = '" . date("d") . "' and month(dataNascimento)='" . date("m") . "' and id not in($sel2) limit 15";
                 $dados   = $wpdb->get_results($Sel, ARRAY_A);
                 $cliente = array();
                 foreach ($dados as $d):
                     $cliente[] = array("nome" => $d['nome'], "id" => $d['id']);
                 endforeach;
                 return $cliente;
             }





             public static function ClientesEnvioEmail() {
                 global $wpdb;
                 $sel2    = " select cliente from logemail where data > '" . date("Y-m-d H:i:s", strtotime("-24 hours")) . "' and tipoEmail='3'";
                 $Sel     = "SELECT id,nome FROM `clientes` where id not in($sel2) order by id limit 20";
                 $dados   = $wpdb->get_results($Sel, ARRAY_A);
                 $cliente = array();
                 foreach ($dados as $d):
                     $cliente[] = array("nome" => $d['nome'], "id" => $d['id']);
                 endforeach;
                 return $cliente;
             }





             public static function ClientesNovos() {
                 global $wpdb;
                 $anterior = date('Y-m-d H:i:s', strtotime('-' . configuracao['cliente_novo'] . ' days'));
                 $hoje     = date("Y-m-d h:i:s");
                 $sel      = "select id, nome from clientes where entrada between '$anterior' and '$hoje'  limit 20";
                 $dados    = $wpdb->get_results($sel, ARRAY_A);
                 $cliente  = array();
                 foreach ($dados as $d):
                     $cliente[] = array("nome" => $d['nome'], "id" => $d['id']);
                 endforeach;
                 return $cliente;
                 ;
             }





             public static function ClientesRecebemEmailsAposDias($dias = "") {
                 global $wpdb;
                 $dias1  = date('Y-m-d 00:00:00', strtotime("-" . $dias . " days"));
                 $dias2  = date('Y-m-d 23:59:59', strtotime("-" . $dias . " days"));
                 $Sel    = "select cliente from logemail where tipoEmail='5' and data between '" . date("y-m-d 00:00:00") . "' and '" . date("y-m-d 23:59:59") . "'";
                 $select = "select cl.id, cl.nome from clientes as cl where cl.id not in($Sel) and  cl.entrada between '$dias1' and '$dias2'group by cl.id  limit 20 ";
                 $dados  = $wpdb->get_results($select, ARRAY_A);
                 foreach ($dados as $d):
                     $emails    = em::EmailCliente($d['id']);
                     $cliente[] = array("nome" => $d['nome'], "id" => $d['id'], "email" => $emails);
                 endforeach;
                 if (!empty($cliente)) {
                     return $cliente;
                 }
             }





             public static $clienteArray;

             public static function DadosCliente() {
                 $id = self::$IdCliente;
                 if (!is_null($id)) {
                     global $wpdb;
                     $sel                  = "select * from clientes where id = '$id'";
                     $x                    = $wpdb->get_row($sel, ARRAY_A);
                     self::$clienteArray   = $x;
                     self::$cliente        = $x;
                     self::$nome           = $x['nome'];
                     self::$tipo_de_pessoa = $x['tipo_de_pessoa'];
                     self::$sexo           = $x['sexo'];
                     self::$cpf            = $x['cpf'];
                     self::$rg             = $x['rg'];
                     self::$dataExpedicao  = $x['dataExpedicao'];
                     self::$dataNascimento = $x['dataNascimento'];
                     self::$ip             = $x['ip'];
                     self::$entrada        = $x['entrada'];
                     self::$documento      = $x['documento'];
                     self::$estado_civil   = $x['estado_civil'];
                     new static();
                 }
             }





             public static function Update() {
                 $dados = $_POST[self::$tabela];
                 if (isset($dados)):
                     db::$id_base = self::$IdCliente;
                     db::$tabela  = clientes;
                     db::$campos  = self::$campos;
                     db::$entrada = $dados;
                     db::Update();
                 endif;
             }





             public static function Formulario($array = "") {
                 db::$tabela = self::$tabela;
                 db::$campos = self::$campos;
                 return db::form($array);
             }





         }
         