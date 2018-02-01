<?php

namespace emailsProcessosEDados;

class Emails
    {

    public static $extension = "";
    public static $texto;
    public static $usuarios;
    public static $envia     = 1;

    
    static public function EnvioAposCadastro() {
        global $wpdb;
        self::$extension = $wpdb->prefix;
        $query           = "select post_id from " . self::$extension . "postmeta where meta_key = 'opcaoDeEmail' and meta_value='2'";
        $dados           = $wpdb->get_results($query, ARRAY_A);
        foreach ($dados as $d):
            self::pegaTexto($d['post_id']);
        endforeach;
    }





    static public function EnvioAniversario() {
        self::$texto     = NULL;
        global $wpdb;
        self::$extension = $wpdb->prefix;
        $query           = "select post_id from " . self::$extension . "postmeta where meta_key = 'opcaoDeEmail' and meta_value='1'";
        $dados           = $wpdb->get_results($query, ARRAY_A);
        foreach ($dados as $d):
            self::pegaTexto($d['post_id']);
        endforeach;
    }





    static public function EnvioAgendado() {
        self::$texto     = NULL;
        global $wpdb;
        self::$extension = $wpdb->prefix;

        $query = "select post_id from " . self::$extension . "postmeta where meta_key = 'opcaoDeEmail' and meta_value='3'";

        $dados = $wpdb->get_results($query, ARRAY_A);
        foreach ($dados as $d):

            $queryOptions = "select * from wptb_postmeta where post_id = '" . $d['post_id'] . "' and meta_key = 'opcaoDeEmailData'";
            $xx           = $wpdb->get_results($queryOptions, ARRAY_A);
            $data_        = $xx[0]['meta_value'];
            $ano          = date("Y", $data_);
            $mes          = date("m", $data_);
            $dia          = date("d", $data_);
            $ddata        = "$ano-$mes-$dia";
            $hoje         = date("Y-m-d");

            if ($ddata === $hoje) {
                //echo "mensagem de hoje";
            } else {
                //echo "sem mensagem hoje";
                self::$envia = 0;
                return;
            }

            $data = self::pegaTexto($d['post_id']);
        endforeach;
        return self::$texto; //print_r(self::$texto);
    }





    static private function pegaTexto($id) {
        global $wpdb;
        self::$extension = $wpdb->prefix;
        $query           = "select * from  " . self::$extension . "posts where id=$id";
        $dados           = $wpdb->get_results($query, ARRAY_A);

        self::$texto[] = array("id" => $dados[0]['ID'], "conteudo" => $dados[0]['post_content'], "titulo" => $dados[0]['post_title']);
    }





    static public function EnvioDeEmails() {
        return self::Aniversario();
    }





    static public function EmailCliente($id = '') {
        if (!is_null($id)) {
            $sel    = "SELECT e.email, e.id FROM `clientesemail` as ce inner join email as e on e.id = ce.email WHERE ce.clientes = '" . $id . "'";
            global $wpdb;
            $emails = $wpdb->get_results($sel, ARRAY_A);
            return $emails;
        }
    }





    public static function TextosParaSeremEnviadosAposDias($id) {
        if(!is_null($id)):
            global $wpdb;
            $sel = "select * from ".$wpdb->prefix."posts where ID = '$id'";
            $dados = $wpdb->get_row($sel,ARRAY_A); 
            
            $dados['metas']= self::Metas($dados['ID']); //$metas;
            
            if(!empty($dados)):
                 return $dados;
            endif;
        endif;
    }


    
    private static function Metas($id){
         $metas= get_post_meta($id); 
         return $metas;
    }



    }
