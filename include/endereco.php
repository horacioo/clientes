<?php

         namespace Planet1;

         use Planet1\DataBase as db;
         use Planet1\estado as estado;
         use Planet1\cidade as cidade;

         class endereco {

             static public $campos  = ['ativo', 'cliente', 'endereco', 'numero', 'complemento', 'cep', 'bairro', 'cidade', 'estado'];
             static private $array;
             static $endereco;
             static $id_endereco;
             static $rua;
             static $numero;
             static $complemento;
             static $cep;
             static $bairro;
             static $cidade;
             static $estado;
             public static $id_cliente;
             private static $tabela = "endereco";

             function __construct() {

                 if (isset($_GET['clienteId'])) {
                     self::$id_cliente = $_GET['clienteId'];
                 }

                 if (isset($_POST[self::$tabela])) {
                     $dados = $_POST[self::$tabela];
                     if (empty($dados['id']) && !empty($dados['telefone'])) {
                         self::$entradaDados = $dados;
                         self::Create();
                     }
                 }
             }





             static function endereco_cliente($id = '') {
                 if (!is_null($id)) {
                     global $wpdb;
                     $sel                           = "SELECT * from endereco WHERE cliente = '$id'";
                     $x                             = $wpdb->get_results($sel, ARRAY_A);
                     self::$array['dadosOriginais'] = $x;
                     return $x;
                 }
             }





             static function Create() {
                 $dados = $_POST[self::$tabela];
                 print_r($dados);
             }





             public static function Update() {
                 db::$entrada = $_POST[self::$tabela];
                 db::$campos  = self::$campos;
                 db::$tabela  = self::$tabela;
                 db::Update();
             }





             public static function Formulario($array = "") {
                 db::$exclude_from_form =array("ativo","cliente");
                 db::$label_form = array("endereco"=>"endereço do cliente");
                 db::$tabela = self::$tabela;
                 db::$campos = self::$campos;
                 return db::form($array);
             }





         }
         