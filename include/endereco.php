<?php

namespace Planet1;

use Planet1\DataBase as db;

class endereco
    {

    static public $campos  = ['ativo', 'cliente', 'endereco', 'numero', 'complemento', 'cep', 'bairro', 'cidade', 'estado'];
    static private $array;
    static $endereco;
    static $id_endereco;
    static $rua;
    static $numero;
    static $complemento;
    static $cep;
    static $bairro;
    static $cidade;
    static $estado;
    public static $id_cliente;
    private static $tabela = "endereco";



    static function endereco_cliente($id = '') {
        if (!is_null($id)) {
            global $wpdb;
            $sel                           = "SELECT end.id,end.endereco,end.numero,end.complemento, end.cep, end.bairro, cid.cidade, est.estado FROM `endereco` as end inner join cidade as cid on cid.id = end.cidade inner join estado as est on est.id = end.estado WHERE cliente = '$id' and ativo =1";
            $x                             = $wpdb->get_results($sel, ARRAY_A);
            self::$array['dadosOriginais'] = $x;
            return $x;
        }
    }



    static function Create() {
        $dados = $_POST[self::$tabela];
        print_r($dados);
        
        
        
        /*
          db::$campos = self::$campos;
          $dados      = $_POST['endereco'];
          $endereco   = $dados['endereco'];
          $endereco   = str_replace("-", ",", $endereco);
          $x          = explode(",", $endereco);

          self::$rua    = trim($x[0]);
          self::$bairro = trim($x[1]);
          self::$cidade = trim($x[2]);
          self::$estado = trim($x[3]);

          db::$tabela = "estado";
          db::$campos = ['estado'];
          db::Salva(array('estado' => self::$estado));
          db::$tabela = "cidade";
          db::$campos = ['cidade', 'estado'];
          db::Salva(array('cidade' => self::$cidade, 'estado' => db::$array['estado'][0]));

          self::$estado = db::$array['estado'][0];
          self::$cidade = db::$array['cidade'][0];

          db::$tabela = "endereco";
          db::$campos = self::$campos;
          $dadosx     = array(
          "ativo"       => 1,
          "cliente"     => self::$id_cliente,
          "endereco"    => self::$rua,
          "numero"      => $dados['numero'],
          "complemento" => "",
          "cep"         => "",
          "bairro"      => self::$bairro,
          "cidade"      => self::$cidade,
          "estado"      => self::$estado);
          db::Salva($dadosx);
         */
    }



    static function Update() {
        db::$campos = self::$campos;


        if (!empty(self::$id_cliente)):

            global $wpdb;
            $wpdb->query("update endereco set ativo = 0 where cliente = '" . self::$id_cliente . "'");
            if (is_array($_POST['endereco']['list'])) {
                foreach ($_POST['endereco']['list'] as $lista):
                    $wpdb->query("update endereco set ativo = 1 where id = '" . $lista . "'");
                endforeach;
            }
        endif;
        if (!empty($_POST['endereco']['endereco'])) {
            self::Create();
        }
    }



    }
