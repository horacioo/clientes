<?php

         namespace Planet1;

         use Planet1\grupos as grupos;
         use Planet1\DataBase as db;

         class Emails {

             //public static $extension     = "";
             //public static $texto;
             //public static $usuarios;
             //public static $envia         = 1;
             private static $campos       = ['produto','apelido','descricao','data'];
             private static $tabela       = "produtos";
             private static $tabela_pivot = "clientesprodutos";
             private static $id;
             //public static $Email_reply_to;
             //public static $Email_replyto_name;
             //public static $Email_from_name;
             //public static $Email_from;
             //public static $Email_Return_Path;
             //public static $nome_cliente;
             //public static $email;
             //public static $entradaDados;
             //public static $conteudo_email;
             //public static $titulo;
             //public static $status;
             //public static $id_cliente;
             public static $id_produtos;
             //public static $id_texto;
             //public static $tipo_do_email;
             //public static $retorno_email;

             function __construct() {

                 if (isset($_GET['clienteId'])) {
                     self::$id_cliente = $_GET['clienteId'];
                 }
                 if (isset($_POST[self::$tabela])) {
                     $dados = $_POST[self::$tabela];
                     if (empty($dados['id']) && !empty($dados['email'])) {
                         self::$entradaDados = $dados;
                         self::Create();
                     }
                 }
             }





             public static function Create() {
                 db::$tabela = self::$tabela;
                 db::$campos = self::$campos;
                 $dados      = self::$entradaDados; //$_POST['email'];
                 $chaves     = array_keys($dados);
                 foreach ($chaves as $c):
                     if (!empty($dados[$c])) {
                         db::Salva(array("produtos" => $dados[$c]));
                         db::$tabela = self::$tabela_pivot;
                         db::$campos = ['clientes', 'produtos'];
                         db::Salva(array("clientes" => self::$id_cliente, "email" => db::$array['email'][0]));
                         ///echo"<hr>". db::$consulta; echo"<hr>";
                         //print_r(array("clientes" => self::$id_cliente, "email" => db::$array['email'][0]));
                         ///echo"<hr>";
                     }
                 endforeach;
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
         