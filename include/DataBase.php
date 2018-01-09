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
    public static $locate;

    protected static function localiza($dados = '') {
        $tabela = self::$tabela;
        $campos = self::$campos;
        if (isset(self::$locate)) {
            $referencia = self::$locate;
        } else{
            $referencia = self::$campos;
        }
        $chaves = array_keys($dados);
        foreach ($chaves as $c):
            if (in_array($c, $referencia)){
                $field .= "and $c = '" . $dados[$c] . "' ";
           }
        endforeach;
        $sel                          = "select id from $tabela where " . $field;
        trim($sel);
        $sel                          = str_replace(array("where and"), "where ", $sel);
        self::$consulta               = $sel;
        global $wpdb;
        $dados                        = $wpdb->get_row($sel, ARRAY_A);
        $id                           = $dados['id'];
        self::$array[self::$tabela][] = $id;
        self::$locate                 = NULL;
    }





    protected static function Salva($array) {
        global $wpdb;
        if (is_array($array)):

            $insert  = "";
            $values  = "";
            $info    = "*";
            $valuesx = array();


            $chaves = self::$campos; //array_keys(self::$campos);
            foreach ($chaves as $ch):
                if (!is_null($array[$ch])){
                    $insert  .= "" . $ch . ",";
                    //$values  .= "'" . $array[$ch] . "',";
                    $valuesx[]= $array[$ch];
                    $info    .= ",%s";
                }
            endforeach;



            $insert .= "*";
            $insert = str_replace(",*", "", $insert);
            //$values .= "*";
            //$values = str_replace(",*", "", $values);
            $info   = str_replace("*,", " ", $info); //"(,";

            self::$consulta = "insert into `" . self::$tabela . "`(" . $insert . ")values(" . $info . ")";

            $prepare=$wpdb->prepare(self::$consulta,$valuesx);


            echo"<hr>";
            print_r(self::$consulta);
            echo"<br>";
            print_r($valuesx);
            echo"<hr>";




            $wpdb->query($prepare);
            $id = $wpdb->insert_id;
            if ($id === 0){
                self::localiza($array);
            } else{
                self::$array[self::$tabela][] = $id;
            }
        endif;
    }





    }
