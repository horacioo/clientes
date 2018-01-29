<?php

namespace Clientes;

use emailsProcessosEDados\Emails as em;
use Grupos\grupos as gr;

class clientes
    {

    static private $campos = ['nome', 'cpf', 'rg', 'dataExpedicao', 'dataNascimento', 'endereco', 'ip', 'entrada'];

    public static function Aniversario() {
        global $wpdb;
        $sel2 = " select cliente from logemail where month(data)='" . date("m") . "' and day(data)='" . date("d") . "' and year(data)='" . date("Y") . "' and tipoEmail=1";
        $Sel  = "SELECT id,nome FROM `clientes` WHERE day(dataNascimento) = '" . date("d") . "' and month(dataNascimento)='" . date("m") . "' and id not in($sel2) limit 5";

        $dados   = $wpdb->get_results($Sel, ARRAY_A);
        $cliente = array();
        foreach ($dados as $d):
            $cliente[] = array("nome" => $d['nome'], "id" => $d['id']);
        endforeach;

        return $cliente;
    }





    public static function ClientesEnvioEmail() {
        global $wpdb;
        $sel2    = " select cliente from logemail where data > '" . date("Y-m-d H:i:s", strtotime("-24 hours")) . "' and tipoEmail=3";
        $Sel     = "SELECT id,nome FROM `clientes` where id not in($sel2)";
        $dados   = $wpdb->get_results($Sel, ARRAY_A);
        $cliente = array();
        foreach ($dados as $d):
            $cliente[] = array("nome" => $d['nome'], "id" => $d['id']);
        endforeach;

        return $cliente;
    }





    public static function EditCliente($id = "") {
        if (!is_null($id)){
            global $wpdb;
            $emails = em::EmailCliente($id);
            $grupos = gr::clienteGrupo($id);
            $sel    = "select cl.id, cl.nome, cl.cpf, cl.rg, cl.dataExpedicao, cl.dataNascimento,cl.endereco  from clientes as cl where id='$id'";
            $x = $wpdb->get_results($sel,ARRAY_A);
            $dados['cliente']=$x[0];
            $dados['emails']=$emails;
            $dados['grupos']=$grupos;
            return $dados;
        }
    }





    }
