<?php

namespace emailsProcessosEDados;

class Emails {

    public static $extension = "";
    public static $texto;
    public static $usuarios;

    static public function EnvioAposCadastro() {
        global $wpdb;
        self::$extension = $wpdb->prefix;
        $query           = "select post_id from " . self::$extension . "postmeta where meta_key = 'opcaoDeEmail' and meta_value='2'";
        $dados           = $wpdb->get_results($query, ARRAY_A);
        foreach ($dados as $d):
            self::pegaTexto($d['post_id']);
        endforeach;
    }







    static private function pegaTexto($id) {
        global $wpdb;
        self::$extension = $wpdb->prefix;
        $query           = "select * from  " . self::$extension . "posts where id=$id";
        $dados           = $wpdb->get_results($query, ARRAY_A);
        self::$texto[]   = array("conteudo"=>$dados[0]['post_content'],"titulo"=>$dados[0]['post_title']);
    }










}
