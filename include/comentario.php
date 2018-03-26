<?php

use Planet1\DataBase;

namespace Planet1;

/**
 * Description of comentario
 *
 * @author horacio
 */
class comentario extends DataBase
    {

    static $id;
    static $postadoPor;
    static $data;
    static $comentario;
    static $id_cliente;



    private static function base() {
        self::$campos  = ['id', 'postadoPor', 'data', 'comentario', 'cliente'];
        self::$tabela  = "comentarios";
        self::$id_base = self::$id_cliente;
    }



    /** para este método funcionar adequadamente, você precisa informar os seguintes dados:
     * <br>$postadoPor;
     * <br>$comentario;
     * <br>$id_cliente;
     * <br>chamar o método normalemente
     */
    public static function SalvaComentario() {
        self::base();
        $dados['postadoPor'] = self::$postadoPor;
        $dados['comentario'] = self::$comentario;
        $dados['cliente']    = self::$id_cliente;
        self::Salva($dados);
    }



    public static function ComentariosDoCliente() {
        self::base();
        DataBase::$campo = "cliente";
        DataBase::$valor =self::$id_cliente;
        return self::MuitosParaUm();
    }



    }
