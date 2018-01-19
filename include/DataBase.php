<?php

class DataBase {
    /***na entrada, vai o nome do formulário, uma string * */
    public static $entrada;   
    public static $obrigatorios;
    public static $insertArray;
    public static $mensagem;
    public static $consulta;
    public static $tabela;
    public static $campos;
    public static $array;
    public static $locate;

    
    
    
    
    /*** enviar por parametro array("tabela"=>"nome da tabela,"limite"=>"10"), senfo que o limite é opcional*/
    public static function ListaGeral($array=''){
        if(is_array($array)):
            $tabela = $array['tabela'];
            if(isset($array['limite'])) {$limit=$array['limite'];} else {$limit  = 20;}
            $sele = "select * from $tabela";
            global $wpdb;
            $dados = $wpdb->get_results($sele,ARRAY_A);
            self::$consulta = $wpdb->last_query;
            return $dados;
        endif;
    }
    
    
    
    
    
    
    
    
    
    
    protected static function localiza($dados = '') {
        global $wpdb;        
        $tabela = self::$tabela;
        $campos = self::$campos;
        $osDados;
      
        if (isset(self::$locate)) 
            {$referencia = self::$locate;} 
              else 
            { $referencia = self::$campos; }
        
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
        self::$locate                 = NULL;
    }


    
    








    public static function Salva($array) {
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
