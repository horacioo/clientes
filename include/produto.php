<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Planet1;

use Planet1\DataBase;

/**
 * Description of produto
 *
 * @author horacio
 */
class produto
    {

    static $produto;
    static $apelido;
    static $descricao;
    static $data_produto;
    static $id_produto;
    static $comissao;
    static $tabela = "produtos";
    static $campos = ['id', 'produto', 'apelido', 'descricao'];
    /*     * ************************* */
    static $clientes;
    static $produtos_pivot;
    static $data;
    static $valor;
    static $ativo;

    /**     * ****************************** */
    static $id_cliente;
    /*     * ************************* */
    static $tabela_pivot = "clientesprodutos";
    static $campos_pivot = ['clientes', 'produtos', 'data', 'valor', 'ativo', 'comissao'];

    /**     * ******************************** */
    static $dadosEntrada;
    /*     * ************************* */
    static $dados_entrada;



    public function __construct() {
        $dados               = $_POST['dados'];
        self::$dados_entrada = $dados;
    }



    /*     * *nao esquecer de instanciar a classe e atribuir valor às variáveis */



    public static function create() {
        DataBase::$campos = self::$campos;
        DataBase::$tabela = self::$tabela;
        $dados            = array("produto" => self::$produto, "apelido" => self::$apelido, "descricao" => self::$descricao);
        DataBase::Salva($dados);
    }



    public static function Update() {
        DataBase::$tabela  = self::$tabela;
        DataBase::$campos  = self::$campos;
        DataBase::$entrada = array("id" => self::$id_produto, "produto" => self::$produto, "apelido" => self::$apelido, "descricao" => self::$descricao);
        DataBase::Update();
    }



    public static function Exclude() {
        DataBase::$del_valor = self::$id_produto;
        DataBase::$del_campo = "id";
        DataBase::$tabela    = self::$tabela;
        DataBase::Del();
    }



    public static function ListaProdutos() {
        return DataBase::ListaGeral(array("tabela" => self::$tabela));
    }



    public static function AssociaProdutos() {
        DataBase::$tabela = self::$tabela_pivot;
        DataBase::$campos = self::$campos_pivot;
        $dados            = array("clientes" => self::$id_cliente, "produtos" => self::$id_produto, "comissao" => self::$comissao, "valor" => self::$valor, "ativo" => self::$ativo);
        DataBase::Salva($dados);
    }



    public static function cadastraProduto() {
        DataBase::$tabela = self::$tabela;
        DataBase::$campos = self::$campos;
        DataBase::Salva(self::$dadosEntrada);
    }



    public static function detalheProduto() {
        database::$id_base = self::$id_produto;
        DataBase::$tabela  = self::$tabela;
        return DataBase::detalhe();
    }



    /** informar o $id_cliente antes de chamar a função** */
    public static function ProdutoDoCliente() {
        DataBase::$campos_da_tabela_principal = self::$campos;
        DataBase::$tabela                     = self::$tabela;
        DataBase::$tabela_pivot               = self::$tabela_pivot;
        DataBase::$campos_pivot               = ['clientes', 'produtos', 'data', 'valor', 'ativo', 'comissao'];
        DataBase::$tabela2                    = "clientes";
        DataBase::$campo_pivot                = "produtos";
        DataBase::$id_base                    = self::$id_cliente;
        return self::calcula_producao(DataBase::temMuitos());
    }



    private static function calcula_producao($dados) {
        $faturamento               = 0;
        $totalDaCorretora          = 0;
        $totalDaCorretoraAcumulado = 0;
        $array                     = array();
        foreach ($dados as $d):
            $faturamento               = $faturamento + $d['valor'];
            $totalDaCorretora          = $d['valor'] * $d['comissao'] / 100;
            $totalDaCorretoraAcumulado = $totalDaCorretoraAcumulado + $totalDaCorretora;
            $d["total"]                = $totalDaCorretora;
            $array[]                   = $d;
        endforeach;
        return $array;
    }



    /**
     * <br>informar o valor da variável "$dadosEntrada"
     * <br>informar o valor da variável "$id_cliente"
     * <br> passar o array com os dados que serão salvos, apenas,
     *  não o array "global", exemplo "$_POST['produtosCliente']" e não $_post[][][]['produtosCliente'] */
    public static function AssociacaoDeClientes() {

        $entrada          = self::$dadosEntrada;
        $cliente          = self::$id_cliente;
        
        
        DataBase::$tabela = self::$tabela_pivot;
        DataBase::$campos = self::$campos_pivot;
        
        DataBase::$del_campo = "clientes";
        DataBase::$del_valor = $cliente;
        DataBase::Del();

        foreach ($entrada as $en):
            if ( $en['ativo']!=0 ) {
                $dados['clientes'] = self::$id_cliente;
                $dados['produtos'] = $en['produto'];
                $dados['valor']    = $en['valor'];
                $dados['ativo']    = $en['ativo'];
                $dados['comissao'] = $en['comissao'];
                self::SalvaAssociacao($dados);
            }
        endforeach;
    }



    private static function SalvaAssociacao($array = '') {
        DataBase::$tabela = self::$tabela_pivot;
        DataBase::$campos = self::$campos_pivot; 
        DataBase::Salva($array);
    }



    /**     * ************************************************ */
    }
