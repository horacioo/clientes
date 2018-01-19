<?php

class DataBase {

    protected static $obrigatorios;
    protected static $insertArray;
    protected static $mensagem;
    protected static $consulta;
    protected static $tabela;
    protected static $campos;
    protected static $array;
    public static $locate;

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    protected static function localiza($dados = '') {
        global $wpdb;        
        $tabela = self::$tabela;
        $campos = self::$campos;
        $osDados;

      
        if (isset(self::$locate)) {
            $referencia = self::$locate;
        } else {
            $referencia = self::$campos;
        }
        
        $field   = "";
        $chaves  = array_keys($dados);
        $campos  = ""; 
        foreach ($chaves as $c):
            if (in_array($c, $referencia)) {
                $campos    .= "and $c = '".$dados[$c]."'";
                $field     .= "and $c = %s ";
                $osDados[]  = $dados[$c];
            }
        endforeach;
        
        
        $sel    = "select id from $tabela where " . $campos;
        $sel    = trim($sel);
        $sel  = str_replace("where and ", "where ", $sel);
        $dados  = $wpdb->get_row($sel, ARRAY_A);
        
        /*
        $sel = "select id from $tabela where " . $field;
        trim($sel);
        $sel = str_replace(array("where and"), "where ", $sel);
        
        $prepare = $wpdb->prepare(self::$consulta, $osDados);
        $dados                        = $wpdb->get_row($prepare, ARRAY_A);
        */
        
        $id                           = $dados['id'];
        self::$array[self::$tabela][] = $id;
        
        //echo"<hr>informação -- ";var_dump($wpdb->last_query);
        //echo"<hr><br>!!! dados retornados "; print_r(self::$array); echo " !!<br>";
        
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
                if (!is_null($array[$ch])) {
                    $insert    .= "" . $ch . ",";
                    $valuesx[] = $array[$ch];
                    $info      .= ",%s";
                }
            endforeach;

            $insert .= "*";
            
            $insert = str_replace(",*", "", $insert);

            $info = str_replace("*,", " ", $info); //"(,";

            self::$consulta = "insert into `" . self::$tabela . "`(" . $insert . ")values(" . $info . ")";

            $prepare        = $wpdb->prepare(self::$consulta, $valuesx);
     
            self::$consulta = $wpdb->last_query; //$sel;
            
            
            $wpdb->query($prepare);
            $id = $wpdb->insert_id;
            if ($id === 0) {
                self::localiza($array);
            } else {
                self::$array[self::$tabela][] = $id;
            }
        endif;
    }










}
