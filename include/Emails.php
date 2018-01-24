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










    static public function EnvioAniversario() {
        global $wpdb;
        self::$extension = $wpdb->prefix;
        $query           = "select post_id from " . self::$extension . "postmeta where meta_key = 'opcaoDeEmail' and meta_value='1'";
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
        self::$texto[]   = array("id"=>$dados[0]['ID'],"conteudo" => $dados[0]['post_content'], "titulo" => $dados[0]['post_title']);
    }










    static public function EnvioDeEmails() {
        return self::Aniversario();
    }










    static public function EmailCliente($id = '') {
        if (!is_null($id)) {
            $sel = "SELECT e.email, e.id FROM `clientesemail` as ce inner join email as e on e.id = ce.email WHERE ce.clientes = '" . $id . "'";
            global $wpdb;
            $emails = $wpdb->get_results($sel,ARRAY_A);
            return $emails;
        }
    }










}
