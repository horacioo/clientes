<?php

namespace Planet1;

use Planet1\DataBase as db;

class telefone
    {

    public static $id_cliente;
    private static $campos      = ['telefone'];
    private static $tabela      = "telefone";
    private static $entradaDados;
    public static $dados_entrada;
    public static $tabela_pivot = "clientestelefone";
    public static $campos_pivot = ['clientes', 'telefone', 'referencia'];



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



    /** Eu apenas preciso informar a variável "$id_cliente" antes de chamar o método ********* */
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



    /**
     * <br>informar o valor da variável "$dadosEntrada"
     * <br>informar o valor da variável "$id_cliente"
     * <br> passar o array com os dados que serão salvos, apenas,
     *  não o array "global", exemplo "$_POST['produtosCliente']" e não $_post[][][]['produtosCliente'] */
    public static function AssociacaoDeClientes() {
        $entrada       = self::$dados_entrada;
        db::$tabela    = self::$tabela_pivot;
        db::$campos    = self::$campos_pivot;
        db::$del_campo = "clientes";
        db::$del_valor = self::$id_cliente;
        db::Del();
        $linha         = -1;
        foreach (self::$dados_entrada as $d):
            if (!empty($d)) {
                $linha++;
                $dados['telefone'] = $d;
                db::$tabela        = self::$tabela;
                db::$campos        = self::$campos;
                db::Salva(array("telefone" => $d));
                $dados['telefone'] = db::$array['telefone'][$linha];
                $dados['clientes'] = self::$id_cliente;
                self::SalvaAssociacao($dados);
            }
        endforeach;
    }



    private static function SalvaAssociacao($array = '') {

        db::$tabela = self::$tabela_pivot;
        db::$campos = self::$campos_pivot;
        db::Salva($array);
    }



    }
