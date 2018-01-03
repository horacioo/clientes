<?php

class DataBase
    {

    protected static $obrigatorios;
    protected static $insertArray;
    protected static $mensagem;
    protected static $consulta;
    protected static $tabela;
    protected static $campos;
    protected static $array;
   

    protected static function Salva($array) {
        global $wpdb;
        if (is_array($array)):
            $insert = "";
            $values = "";
            $chaves = self::$campos; //array_keys(self::$campos);
            foreach ($chaves as $ch):
                $insert .= "" . $ch . ",";
                $values .= "'" . $array[$ch] . "',";
            endforeach;

            $insert                       .= "*";
            $insert                       = str_replace(",*", "", $insert);
            $values                       .= "*";
            $values                       = str_replace(",*", "", $values);
            self::$consulta               = "insert into `" . self::$tabela . "`(" . $insert . ")values(" . $values . ")";
            $wpdb->query(self::$consulta);
            $id                           = $wpdb->insert_id;
            self::$array[self::$tabela][] = $id;
        endif;
    }





    }
