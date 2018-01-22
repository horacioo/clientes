<?php

namespace ProcessosDeEmails;

header('Access-Control-Allow-Origin: *');
require_once '../../../../wp-config.php';

class EnvioEmail
    {

    public static $extension = "wp_";
    public static $texto;
    public static $usuarios;

    static public function EnvioAposCadastro() {
        global $wpdb;
        $query = "select post_id from " . self::$extension . "postmeta where meta_key = 'opcaoDeEmail' and meta_value='2'";
        $dados = $wpdb->get_results($query, ARRAY_A);
        foreach ($dados as $d):
            self::pegaTexto($d['post_id']);
        endforeach;
    }





    static private function pegaTexto($id) {
        global $wpdb;
        $query         = "select * from  " . self::$extension . "posts where id=$id";
        $dados         = $wpdb->get_results($query, ARRAY_A);
        self::$texto[] = $dados[0]['post_content'];
    }





    }

use ProcessosDeEmails\EnvioEmail as mail;

if ($_GET['EmailsAposCadastro'] == 1):
            mail::EnvioAposCadastro();
            echo json_encode(mail::$texto);
    endif;
