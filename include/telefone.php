<?php

namespace Planet1;

use Planet1\DataBase as db;

class telefone
    {

    public static $id_cliente;
    private static $campos = ['telefone'];
    private static $tabela = "telefone";



    public static function Telefone_do_cliente($id_cliente = "") {
        if (!is_null($id_cliente)):
            global $wpdb;
            $sel   = "SELECT tel.id, tel.telefone FROM `clientestelefone` as ct INNER join telefone as tel on tel.id=ct.telefone WHERE ct.clientes = '$id_cliente'";
            $lista = $wpdb->get_results($sel, ARRAY_A);
            return $lista;
        endif;
    }



  
    public static function Update() {
        $dados  = $_POST[self::$tabela];
        $chaves = array_keys($dados);
        
        foreach ($chaves as $c):
            /*             * ************************** */
            if ($c > 0) {
                if (!empty($dados[$c])) {
                    $query = "update " . self::$tabela . " set " . self::$campos[0] . "='" . $dados[$c] . "' where id='" . $c . "'";
                } else {
                    $query = "delete from " . self::$tabela . " where id = '" . $c . "'";
                }
                db::Query($query);
            } else {
                self::Create();
            }
            /*             * ************************** */
        endforeach;
    }


     public static function Create() {
        db::$tabela = self::$tabela;
        db::$campos = self::$campos;
        $dados      = $_POST[self::$tabela];
        $chaves     = array_keys($dados);
        foreach ($chaves as $c):
            /*             * ************************** */
            if ($c === 0) {
                if (!empty($dados[$c])) {
                    db::Salva(array("telefone" => $dados[$c]));
                    db::$tabela = "clientestelefone";
                    db::$campos = ['clientes', 'telefone'];
                    db::Salva(array("clientes" => self::$id_cliente, "telefone" => db::$array['telefone'][0]));
                 }
            }
            /*             * ************************** */
        endforeach;
    }


    }
