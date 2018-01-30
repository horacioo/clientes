<?php

namespace Grupos;

class grupos
    {
    /*     * * 
      aqui eu vou, com base no id do cliente, selecionar os grupos ao qual o cliente faz parte
     * */

    static public function clienteGrupo($cliente = '') {
        if (!is_null($cliente)):
            $sel   = "select cg.cliente, cg.grupo , gr.nome "
                    . "from clientesgrupos as cg "
                    . "inner join grupos as gr on gr.id = cg.grupo "
                    . "where cg.cliente = '" . $cliente . "'";
            global $wpdb;
            $dados = $wpdb->get_results($sel, ARRAY_A);
            return $dados;
        endif;
    }





    /*     * * 
      aqui eu vou, com base no id do grupo, vou retornar todos os clientes pertecentes ao mesmo
     * */

    static public function gruposClientes($idDoTexto) {
        $grupo = get_post_meta($idDoTexto, "grupo");
        $gr    = unserialize($grupo[0]);
        $dados = 0;
        if (is_array($gr)) {
            foreach ($gr as $gr):
                $dados .= ",$gr";
            endforeach;
        }
        $info;
        $sel   = "select cg.cliente from clientesgrupos as cg where grupo in ($dados) group by cliente";
        global $wpdb;
        $dados = $wpdb->get_results($sel, ARRAY_A);
        if (is_array($dados)) {
            foreach ($dados as $d):
                $info[] = $d['cliente'];
            endforeach;
        }
        return $info;
    }





    /*     * aqui eu retornno uma lista dos grupos existentes */

    static public function listadeGrupos() {
        global $wpdb;
        $select = "select * from grupos ";
        $lista  = $wpdb->get_results($select, ARRAY_A);
        return $lista;
    }





    }
