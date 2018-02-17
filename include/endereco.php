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
                     $sel                           = "SELECT end.id,end.endereco,end.numero,end.complemento, end.cep, end.bairro, cid.cidade, est.estado FROM `endereco` as end inner join cidade as cid on cid.id = end.cidade inner join estado as est on est.id = end.estado WHERE cliente = '$id' and ativo =1";
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
                 db::$tabela = self::$tabela;
                 db::$campos = self::$campos;
                 return db::form($array);
             }





         }
         