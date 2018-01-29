<?php

namespace Grupos;
class grupos
    {
    /*** 
    aqui eu vou, com base no id do cliente, selecionar os grupos
    **/
    static public function clienteGrupo($cliente=''){
        if(!is_null($cliente)):
            $sel="select cg.cliente, cg.grupo , gr.nome "
                . "from clientesgrupos as cg "
                . "inner join grupos as gr on gr.id = cg.grupo "
                . "where cg.cliente = '".$cliente."'";
        global $wpdb;
        $dados = $wpdb->get_results($sel,ARRAY_A);
        return $dados;
        endif;
    }
    
    
    /**aqui eu retornno uma lista dos grupos existentes*/
    static public function listadeGrupos(){
        global $wpdb;
        $select= "select * from grupos ";
        $lista = $wpdb->get_results($select, ARRAY_A);
        return $lista;
    }
    
    
    
    }
