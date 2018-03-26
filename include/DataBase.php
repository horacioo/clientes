<?php

namespace Planet1;

class DataBase
    {
    /*     * *na entrada, vai o nome do formulário, uma string * */

    public static $entrada;
    public static $obrigatorios;
    public static $insertArray;
    public static $mensagem;
    public static $consulta;
    public static $tabela;
    public static $campos;
    public static $array;
    public static $locate;
    public static $id_base;
    public static $exclude_from_form;
    public static $label_form;
    public static $response;
    public static $limit = 10;
    /*     * *************** */
    public static $pivot;
    public static $mae;
    public static $filha;
    public static $campo;
    public static $valor;

    /*     * *************** */



    /**     * Essa função vai retornar um registro baseado em um id informado...<br>
     * deve ser marcado a variável "$tabela" e "$id_base" , daí, chamar o método* */
    public static function detalhe() {
        $sel = "select * from `" . self::$tabela . "` where id='" . self::$id_base . "' ";
        global $wpdb;
        return $wpdb->get_row($sel, ARRAY_A);
    }



    /**     * enviar por parametro array("tabela"=>"nome da tabela,"limite"=>"10"), senfo que o limite é opcional */
    public static function ListaGeral($array = '') {
        if (is_array($array)):
            $tabela = $array['tabela'];
            if (isset($array['limite'])) {
                $limit = $array['limite'];
            } else {
                $limit = 20;
            }
            $sele           = "select * from $tabela";
            global $wpdb;
            $dados          = $wpdb->get_results($sele, ARRAY_A);
            self::$consulta = $wpdb->last_query;
            return $dados;
        endif;
    }



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

        $field  = "";
        $chaves = array_keys($dados);
        $campos = "";
        foreach ($chaves as $c):
            if (in_array($c, $referencia)) {
                $campos    .= "and $c = '" . $dados[$c] . "'";
                $field     .= "and $c = %s ";
                $osDados[] = $dados[$c];
            }
        endforeach;


        $sel   = "select id from $tabela where " . $campos;
        $sel   = trim($sel);
        $sel   = str_replace("where and ", "where ", $sel);
        $dados = $wpdb->get_row($sel, ARRAY_A);

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



    /** Esse método vai me retornar consultas do tipo 'like'  
     * <br><br>
     * enviar <b style='color:green'>array("campo"=>"nome", "like"=>"hor")</b> e informar a tabela na variável <b style='color:green'>$tabela</b> 
     * <br> os dados serão resgatados na variável <b style='color:green'>$response</b>* */
    public static function like($dados) {
        global $wpdb;
        $campo          = $dados['campo'];
        $valor          = $dados['like'];
        $sel            = "select * from `" . self::$tabela . "` where " . $campo . " like'%" . $valor . "%' limit " . self::$limit . " ";
        self::$consulta = $sel;
        self::$response = $wpdb->get_results($sel, ARRAY_A);
    }



    /**     * preciso passar uma array de campos, o nome da tabela e a array com os campos e dados, exemplo:<br>
     * <br><b>db::$tabela = uma tabela qualquer; a tabela</b> 
     * <br><b>db::$campos = ['clientes', 'email']; os campos</b> 
     * <br><b>db::Salva(array("clientes" => self::$id_cliente, "email" => db::$array['email'][0]));</b> 
     * * */
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

            $prepare = $wpdb->prepare(self::$consulta, $valuesx);

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



    /**     * *
     * para esse metodo funcionar, vc precisa passar a entrada os parametros:<br>
     * segue um exemplo:<br>
      db::$id_base = self::$IdCliente;<br>
      db::$tabela  = clientes;<br>
      db::$campos  = self::$campos;<br>
      db::$entrada = $formulario;<br>
     */
    /*     * *
      informar a tabela na variável <b style='color:green'>$tabela</b> <br>
      informar os campos na variável <b style='color:green'>$campos</b> <br>
      <br>
      passar a array com os dados que serão alterados, essa array deve ser passada pela variável <b style='color:green'>self::$entrada</b>
      <br> exemplo<b style='color:orange'>objeto::$entrada = array("produto" => self::$produto, "descricao" => self::$descricao);</b>
      <br>chamar o método <b style='color:green'>Update()</b>
     * * */



    /** para este método funcionar,<b style='color:red'>o valor do id deve ir no formulário</b> , como um campo, apenas informar o id não funciona */
    public static function Update() {

        //print_r(self::$entrada);

        $chaves        = array_keys(self::$entrada);
        $update        = "";
        self::$id_base = self::$entrada['id'];
        $up            = "update " . self::$tabela . " set ";
        foreach ($chaves as $e):
            if (in_array($e, self::$campos)):
                $up .= ", $e ='" . self::$entrada[$e] . "'";
            endif;
        endforeach;
        $up .= " where id = '" . self::$id_base . "'";
        $up = str_replace("set ,", "set ", $up);

        global $wpdb;
        $wpdb->query($up);
        self::$consulta = $wpdb->last_query;
    }



    public static $del_campo;
    public static $del_valor;



    /**     * informar antes de executar essa função, os valores de $del_campo e $del_valor, além, claro, da tabela** */
    public static function Del() {
        global $wpdb;
        if (!empty(self::$del_campo) && !empty(self::$del_valor)) {
            $del = "delete from " . self::$tabela . " where " . self::$del_campo . " = '" . self::$del_valor . "'";
            $wpdb->query($del);
        }
    }



    public static function Query($query = '') {
        global $wpdb;
        $wpdb->query($query, ARRAY_A);
    }



    public static function form($array = "") {
        self::excludeFromForm();

        $form = "<div class='dynamic_form'>";
        $form .= "<form action='' method='POST' name='" . self::$tabela . "'>";
        if (is_array($array)) {
            $form .= "<input type='hidden' name=" . self::$tabela . "[id] value='" . $array['id'] . "'>";
        }

        foreach (self::$campos as $c):
            if (is_array($array)) {
                $valor;
                if (!empty($array[$c])) {
                    $valor = $array[$c];
                } else {
                    $valor = "x";
                }
                $form .= "<label>" . self::trocaLabel($c) . "</label><input class='form-control' type='text' name=" . self::$tabela . "[" . $c . "]  value='" . $valor . "' >";
            } else {
                $form .= "<label>" . self::trocaLabel($c) . "</label><input class='form-control' type='text'  name=" . self::$tabela . "[" . $c . "]>";
            }
        endforeach;
        $form .= "<input type='submit' value='enviar' class='btn btn-success'>";
        $form .= "</form>";
        $form .= "</div>";
        return $form;
    }



    private static function trocaLabel($original = '') {
        if (is_array(self::$label_form)) {
            $int   = -1;
            $chave = array_keys(self::$label_form);
            foreach (self::$campos as $c):
                $int++;
                if (in_array($original, $chave)):
                    if (!empty(self::$label_form[$c])) {
                        //echo "<br>o campo $c($int) será alterado por " . self::$label_form[$c];
                        $original = self::$label_form[$c];
                    }
                endif;
            endforeach;
        }
        return $original;
    }



    private static function excludeFromForm() {
        if (is_array(self::$exclude_from_form)):
            $int = -1;
            foreach (self::$campos as $c):
                $int++;
                if (in_array($c, self::$exclude_from_form)) {
                    unset(self::$campos[$int]);
                }
            endforeach;
        endif;
    }



    /** Essa $variavel representa a tabela principal da classe, 
     * <br>ex.:database\$campos_da_tabela_principal = self::$campos */
    static $campos_da_tabela_principal;

    /** é a tabela que vai interagir com a sua tabela principal, 
      <br>ex.:a tabela principal é <b style='color:green'>produtos</b>, e vai interagir com essa tabela, é a <b style='color:green'>clientes</b>, tabela2 então, é <b style='color:green'>clientes</b> */
    static $tabela2; //      = "clientes";
    static $campo_pivot; //  = "produtos";
    static $tabela_pivot; // = "clientesprodutos";
    static $campos_pivot; //  = ['clientes', 'produtos', 'data', 'valor', 'ativo', 'comissao'];

    /**
      <br>campos essenciais para o funcionanento do metodo
      <br>static $campo_pivot  = "produtos";
      <br>static $campos_da_tabela_principal;
      <br>static $tabela
      <br>static $tabela_pivot;
      <br>static $campos_pivot;
      <br>static $tabela2;
      <br>static $campo_pivot;
     * 
     * 
     * 
     *  ************************************************* */



    public static function temMuitos() {
        $camposPivot = self::$campos_pivot;
        $campos      = self::$campos_da_tabela_principal;
        /**         * ************************************* */
        $campo       = "";
        /**         * ************************************* */
        foreach ($camposPivot as $x):
            $campo .= "z." . $x . ", ";
        endforeach;
        /**         * ************************************* */
        foreach ($campos as $x):
            $campo .= "x." . $x . ", ";
        endforeach;
        /**         * ************************************* */
        $campo .= "**";
        /**         * ************************************* */
        $campo = str_replace(", **", " ", $campo);
        /**         * ************************************* */
        $sel   = "SELECT 
                $campo
                FROM `" . self::$tabela_pivot . "` as z
                inner join `" . self::$tabela . "` as x on x.id = " . self::$campo_pivot . "
                WHERE `" . self::$tabela2 . "` = " . self::$id_base . "";

        global $wpdb;
        self::$consulta = $sel;
        return $wpdb->get_results($sel, ARRAY_A);
    }



    /**
     * para este método funcionar adequadamente, você precisa informar as variáveis
      <br>$tabela,
      <br>$campo,
      <br>$valor,
      <br>chamar o método
     */
    public static function MuitosParaUm() {
        $sel = "select * from `" . self::$tabela . "` where " . self::$campo . "='" . self::$valor . "' order by id desc ";
        global $wpdb;
        return $wpdb->get_results($sel, ARRAY_A);
    }



    }
