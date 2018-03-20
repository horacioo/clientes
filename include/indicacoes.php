<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Planet1;

use Planet1\DataBase;

/**
 * Description of indicacoes
 *
 * @author horacio
 */
class indicacoes
    {

    static $tabela      = "indicacao";
    static $campos      = ['quemIndicou', 'indicado'];
    static $cliente;
    static $quemIndicou = "";
    

    public static function Create() {
        DataBase::$tabela = self::$tabela;
        DataBase::$campos = self::$campos;
        DataBase::Salva(array("quemIndicou"=>self::$quemIndicou,"indicado"=>self::$cliente));
    }



    //put your code here
    }
