<?php

namespace emailsProcessosEDados;

class Emails
    {

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
        self::$texto[]   = array("conteudo" => $dados[0]['post_content'], "titulo" => $dados[0]['post_title']);
    }





    static public function EnvioDeEmails() {
        return self::Aniversario();
    }





    private static function Aniversario() {
        global $wpdb;
        $Sel   = "SELECT * FROM `clientes` WHERE day(dataNascimento) = '" . date("d") . "' and month(dataNascimento)='" . date("m") . "'";
        $Sel   = "SELECT cli.nome, e.email 
                  FROM `clientes` as cli
                  inner join clientesemail as cle on cle.clientes = cli.id
                  inner join email as e on e.id = cle.email
                  WHERE day(cli.dataNascimento) = '" . date("d") . "' and month(cli.dataNascimento)='" . date("m") . "'";
        $dados = $wpdb->get_results($Sel, ARRAY_A);
        foreach ($dados as $d):
                   echo "<hr> ".$d['nome']." ||";
                   echo "  ".$d['email']."<hr>";
                   //envia email
                   //os que forem enviados,salvo informação em tabela com o tipo de email no caso, de aniversário, é 1
                   //próximo
        endforeach;
    }
    
    
    private static function Email(){}
    private static function salvaEmTabela(){}

          





    }
