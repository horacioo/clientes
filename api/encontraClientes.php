<?php

header('Access-Control-Allow-Origin: *');

if (isset($_GET['dados'])):
    $dados   = $_GET['dados'];
    $cliente = $_GET['nome'];

    require_once '../../../../wp-config.php';
    require_once '../include/DataBase.php';
    require_once '../include/clientes.php';
    require_once '../include/Emails.php';
    require_once '../include/telefone.php';
    require_once '../include/indicacoes.php';

    if (!is_null($cliente) && $cliente != ""):
        Planet1\clientes::$nome        = $cliente;
        Planet1\clientes::$limiteDados = "10";
        $x                             = Planet1\clientes::localizaClientes();
        $x                             = Planet1\clientes::$listaDeClientes; //clientes::$listaDeClientes;

        foreach ($x as $x):
            \Planet1\telefone::$id_cliente = $x['id'];
            $id                            = $x['id'];
            $nome                          = $x['nome'];
            $tipo_de_pessoa                = $x['tipo_de_pessoa'];
            $sexo                          = $x['sexo'];
            $cpf                           = $x['cpf'];
            $rg                            = $x['rg'];
            $dataExpedicao                 = $x['dataExpedicao'];
            $dataNascimento                = $x['dataNascimento'];
            $documento                     = $x['documento'];
            $estado_civil                  = $x['estado_civil'];
            $indicadoPor                   = \Planet1\indicacoes::IndicadoPor($id);
            $telefone                      = \Planet1\telefone::Telefone_do_cliente();
            $email                         = Planet1\Emails::EmailCliente($id);
            Planet1\produto::$id_cliente   = $id;
            $produtos                      = Planet1\produto::ProdutoDoCliente();
            $endereco                      = $clientes[]                    = array(
                "id"             => $id,
                "nome"           => $nome,
                "tipo_de_pessoa" => $tipo_de_pessoa,
                "sexo"           => $sexo,
                "cpf"            => $cpf,
                "rg"             => $rg,
                "dataExpedicao"  => $dataExpedicao,
                "dataNascimento" => $dataNascimento,
                "documento"      => $documento,
                "estadoCivil"    => $estado_civil,
                "telefone"       => $telefone,
                "email"          => $email,
                "produto"       => $produtos,
                "indicacao"      => array("nome" => \Planet1\clientes::$nome, "id" => \Planet1\clientes::$IdCliente),
            );

        endforeach;
        echo json_encode($clientes);
    endif;

    
endif;

