<?php

namespace Planet1;

use Planet1\grupos as grupos;
use Planet1\DataBase as db;

class Emails
    {

    public static $extension = "";
    public static $texto;
    public static $usuarios;
    public static $envia     = 1;
    private static $campos   = ["email"];
    private static $tabela   = "email";



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
        if (!is_null($id)):
            global $wpdb;
            $sel   = "select * from " . $wpdb->prefix . "posts where ID = '$id'";
            $dados = $wpdb->get_row($sel, ARRAY_A);

            $dados['metas'] = self::Metas($dados['ID']); //$metas;

            if (!empty($dados)):
                return $dados;
            endif;
        endif;
    }



    private static function Metas($id) {
        $metas = get_post_meta($id);
        return $metas;
    }



    public static $Email_reply_to;
    public static $Email_replyto_name;
    public static $Email_from_name;
    public static $Email_from;
    public static $Email_Return_Path;
    public static $nome_cliente;
    public static $email;
    public static $conteudo_email;
    public static $titulo;
    public static $status;



    public static function DisparaEmail() {
        self::Reconstroi();
        $headers = "MIME-Version: 1.1\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8 \r\n";
        $headers .= "From: " . self::$Email_from_name . " <" . self::$Email_from . ">  \r\n"; // remetente
        $headers .= 'Reply-To: ' . self::$Email_replyto_name . ' <' . self::$Email_reply_to . '>';
        $headers .= "Return-Path: " . self::$Email_Return_Path . "  \r\n"; // return-path
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "X-Priority: 3\r\n";
        $headers .= "X-Mailer: PHP" . phpversion() . "\r\n";
        $status  = mail(self::$email, self::$titulo, self::$conteudo_email, $headers);
        if ($status == TRUE) {
            echo "\r\n e-mail enviado para " . self::$email;
            self::$retorno_email = $status;
            self::$status        = 1;
            self::salva_dados();
            return 1;
        } else {
            self::$status = 0;
            self::salva_dados();
            return 0;
        }
    }



    public static $id_cliente;
    public static $id_email;
    public static $id_texto;
    public static $tipo_do_email;
    public static $retorno_email;



    private static function salva_dados() {
        global $wpdb;
        $insert = "insert into `logemail`(cliente,email,texto,tipoEmail,resultado)values(" . self::$id_cliente . "," . self::$id_email . "," . self::$id_texto . "," . self::$tipo_do_email . "," . self::$retorno_email . ")";
        //echo "\r\n \r\n \r\n $insert \r\n";
        $wpdb->query($insert);
    }



    /*     * *  
      eu mando o conteúdo e um array, nesse array, pode ter nome, data, e outros valores...
      mandar o array da seguinte forma array("nome"=>"x","idade"=>"y", "informação"=>"z")
      e por aí vai...
     * */



    private static function Reconstroi($conteudo = '') {
        $nome                 = self::$nome_cliente;
        $conteudo             = self::$conteudo_email;
        self::greetings();
        /*         * ******************************************** */
        $nomeArray            = explode(" ", ucfirst($nome));
        /*         * ******************************************** */
        self::$conteudo_email = str_replace("%nome%", $nomeArray[0], self::$conteudo_email);
        /*         * ******************************************** */
        self::$conteudo_email = str_replace("%saudacao%", self::$saudacao, self::$conteudo_email);
        /*         * ******************************************** */
        self::$conteudo_email = ucfirst(self::$conteudo_email);
        /*         * ******************************************** */

        self::$titulo = self::$nome_cliente . " - " . self::$titulo . "";
    }



    private static $saudacao;



    private static function greetings() {
        $hora           = date("H");
        self::$saudacao = "olá";
        switch ($hora):
            case 1:
            case 2:
            case 3:
            case 4:
            case 5:
            case 6:
            case 7:
            case 8:
            case 9:
            case 10:
            case 11:
            case 12: self::$saudacao = "bom dia";
                break;
            case 13:
            case 14:
            case 15:
            case 16:
            case 17:self::$saudacao = "boa tarde";
                break;
            case 18: self::$saudacao = "boa noite";
                break;
            case 19:
            case 20:
            case 21:
            case 22:
            case 23:
            case 24: self::$saudacao = "bom dia";
                break;
            default: self::$saudacao = "olá  ";
        endswitch;
    }



    public static function Create() {
        db::$tabela = self::$tabela;
        db::$campos = self::$campos;
        $dados      = $_POST['email'];
        $chaves     = array_keys($dados);
        foreach ($chaves as $c):
            /*             * ************************** */
            if ($c === 0) {
                if (!empty($dados[$c])) {
                    db::Salva(array("email" => $dados[$c]));
                    db::$tabela = "clientesemail";
                    db::$campos = ['clientes', 'email'];
                    db::Salva(array("clientes" => self::$id_cliente, "email" => db::$array['email'][0]));
                }
            }
            /*             * ************************** */
        endforeach;
    }



    public static function Update() {
        $dados  = $_POST[self::$tabela];
        $chaves = array_keys($dados);
        foreach ($chaves as $c):
            /*             * ************************** */
            if ($c > 0) {
                if (!empty($dados[$c])) {
                    $query = "update " . self::$tabela . " set ".self::$campos[0]."='" . $dados[$c] . "' where id='" . $c . "'";
                } else {
                    $query = "delete from " . self::$tabela . " where id = '" . $c . "'";
                }
                db::Query($query);
            } else {
                self::Create();
            }
            /*             * ************************** */
        endforeach;
    }



    }
