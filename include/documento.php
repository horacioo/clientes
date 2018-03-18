<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Planet1;

/**
 * Description of documento
 *
 * @author horacio
 */
class documento
    {

    static $id_cliente;
    static $documento;



    static function relacao_documento() {
        if (isset(self::$id_cliente)):
            global $wpdb;
            $query = "select * from documento where id = '" . self::$documento . "'";
            $x     = $wpdb->get_row($query, ARRAY_A);
            return $x;
        endif;
    }



    static function lista_documento() {
        global $wpdb;
        $query = "select * from documento";
        $x     = $wpdb->get_results($query, ARRAY_A);
        return $x;
    }



    public static function documento_salva() {
        DataBase::$tabela = "documento";
        DataBase::$campos = ['documento', 'nome'];
        if (!empty(self::$documento)) {
            $array = array("documento" => self::$documento);
            DataBase::Salva($array);
        }
    }



    }
