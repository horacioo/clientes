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
    static $tabela       = "produtos";
    /*     * ************************* */
    static $id_cliente;
    /*     * ************************* */
    static $clientes;
    static $produtos_pivot;
    static $data;
    static $valor;
    static $ativo;
    static $tabela_pivot = "clientesprodutos";
    static $campos       = ['produto', 'apelido', 'descricao', 'data'];
    static $campos_pivot = ['clientes', 'produtos', 'data', 'valor', 'ativo'];
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



    public static function ListaProdutos() {
        return DataBase::ListaGeral(array("tabela" => self::$tabela));
    }



    public static function AssociaProdutos() {
        DataBase::$tabela = self::$tabela_pivot;
        DataBase::$campos = self::$campos_pivot;
        $dados            = array("clientes" => self::$id_cliente, "produtos" => self::$id_produto, "valor" => self::$valor, "ativo" => self::$ativo);
        print_r($dados);
        DataBase::Salva($dados);
    }



    public static function cadastraProduto() {
        DataBase::$tabela = self::$tabela;
        DataBase::$campos = self::$campos;
        DataBase::Salva(self::$dadosEntrada);
    }

    


    }
