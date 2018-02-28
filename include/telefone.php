<?php

namespace Planet1;

use Planet1\DataBase as db;

class telefone
    {

    public static $id_cliente;
    private static $campos = ['telefone'];
    private static $tabela = "telefone";
    private static $entradaDados;
    public static $dados_entrada;



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



    public static function Create() {
        db::$tabela = self::$tabela;
        db::$campos = self::$campos;
        $dados      = self::$dados_entrada; //$_POST[self::$tabela];
        if (!empty($dados)) {
            $chaves = array_keys($dados);
            foreach ($chaves as $c):
                /*                 * ************************** */
                if (!empty($dados[$c])) {
                    db::Salva(array("telefone" => $dados[$c]));
                    db::$tabela = "clientestelefone";
                    db::$campos = ['clientes', 'telefone'];
                    db::Salva(array("clientes" => self::$id_cliente, "telefone" => db::$array['telefone'][0]));
                }
                /*                 * ************************** */
            endforeach;
        }
    }



    public static function Telefone_do_cliente() {
        $id_cliente = self::$id_cliente;
        if (!is_null($id_cliente)):
            global $wpdb;
            $sel   = "SELECT tel.id, tel.telefone FROM `clientestelefone` as ct INNER join telefone as tel on tel.id=ct.telefone WHERE ct.clientes = '$id_cliente'";
            $lista = $wpdb->get_results($sel, ARRAY_A);
            return $lista;
        endif;
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
