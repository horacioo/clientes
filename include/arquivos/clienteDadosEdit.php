<?php

use Planet1\clientes as cli;
use Planet1\DataBase as db;
use Planet1\EstadoCivil as ec;
use Planet1\Emails as em;
use Planet1\endereco as end;
use Planet1\telefone as tel;
use Planet1\grupos as gru;
use Planet1\cidade as cid;
use Planet1\estado as est;
use Planet1\documento as doc;

doc::$id_cliente = $_GET['clienteId'];
cli::$IdCliente  = $_GET['clienteId'];
end::$id_cliente = $_GET['clienteId'];
tel::$id_cliente = $_GET['clienteId'];

if (isset($_POST['clientes'])) {
    cli::Update();
}
if (isset($_POST['email'])) {
    em::Update();
}
if (isset($_POST['telefone'])) {
    tel::Update();
}
if (isset($_POST['endereco'])) {
    end::Update();
}
ec::Lista_Estado_Civil();
new em();
new tel();
cli::DadosCliente();
?>


<!--<script src="http://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.4/angular.min.js" ></script>-->



<style>
    .formularioEndereco{
        margin-bottom: 20px;
        padding: 20px;
        background-color: #fbfbfb;
        border: 1px solid #d0d0d0;
        margin-top: 13px;
        border-radius: 7px;
    }
    .formularioEndereco p{border: 0px solid red;}
    .desativado{
        background-color: #f3f3f3;
        color: #d0d0d0;
    }
    .desativado input,.desativado select,.desativado radio{color: #d0d0d0;}
</style>




<div class="container" ng-app>
    <div class="row" >
        <div class="col-md-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#aba_geral" role="tab" aria-controls="aba_geral">Geral</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#aba_enderecos" role="tab" aria-controls="aba_enderecos">Endereços</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#aba_email" role="tab" aria-controls="aba_email">E-mails</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#aba_telefones" role="tab" aria-controls="aba_telefones">Telefones</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#aba_relacao" role="tab" aria-controls="aba_relacao">Relação</a>
                </li>
            </ul>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="tab-content">
                <div class="tab-pane active" id="aba_geral" role="tabpanel">
                    <form action="" method="post" >
                        <p><label>nome</label><input type="text" class="form-control" name=clientes[nome] value="<?php echo cli::$nome ?>"></p>
                        <p><label>tipo de pessoa</label>
                            <label>física</label><input type="radio" <?php if (cli::$tipo_de_pessoa === "f") { ?>checked="checked"<?php } ?> name=clientes[tipo_de_pessoa] value="f">
                            <label>juridica</label><input type="radio" <?php if (cli::$tipo_de_pessoa === "j") { ?>checked="checked"<?php } ?>  name=clientes[tipo_de_pessoa] value="j">
                        </p>
                        <p><label>estado civil</label>
                            <select name=clientes[estado_civil]>
                                <?php foreach (ec::$Lista_Estado_Civil as $ec): ?>
                                    <option value="<?php echo $ec['id']; ?>" <?php
                                    if (cli::$estado_civil === $ec['id']) {
                                        echo " selected=\"selected\"";
                                    }
                                    ?> ><?php echo $ec['estado_civil'] ?></option>
                                        <?php endforeach; ?>
                            </select>
                        </p>
                        <p><label>cpf</label><input type="text" class="form-control" name=clientes[nome] value="<?php echo cli::$cpf ?>"></p>
                        <p><label>sexo</label>
                            <?php if (cli::$sexo === "m") { ?>
                                <label>masculino</label><input type="radio" name=clientes[sexo] checked="checked" value="1">
                                <label>feminino</label><input type="radio" name=clientes[sexo] value="2">
                            <?php } else { ?>
                                <label>masculino</label> <input type="radio" name=clientes[sexo] value="1">
                                <label>feminino</label>  <input type="radio" name=clientes[sexo] checked="checked" value="2">
                            <?php } ?>
                        </p>
                        <input type="submit" value="salvar" class="btn btn-warning">
                    </form>
                </div>

                <div class="tab-pane" id="aba_enderecos" role="tabpanel">



                    <!------------------------------------------------->
                    <!------------------------------------------------->
                    <!------------------------------------------------->
                    <?php foreach (end::endereco_cliente(cli::$IdCliente) as $end): ?>
                        <form action="" method="post" class="formularioEndereco <?php
                        if ($end['ativo'] != 1) {
                            echo "desativado";
                        }
                        ?>" >
                            <!------------------------------------------------->
                            <input type="hidden" name="endereco[id]" value="<?php echo $end['id']; ?>">
                            <h3>alterar endereço <?php echo $end['endereco'] ?></h3>
                            <!------------------------------------------------->

                            <div class="container">
                                <div class="row">
                                    <p class="endereco col-md-5"><label>endereço</label><input class="form-control" type="text" name="endereco[endereco]" value="<?php echo $end['endereco']; ?>"></p>
                                    <p class="numero col-md-2"><label>número</label><input class="form-control"  type="text" name="endereco[numero]" value="<?php echo $end['numero']; ?>"></p>
                                    <p class="complemento col-md-3"><label>complemento</label><input  class="form-control"  type="text" name="endereco[complemento]" value="<?php echo $end['complemento']; ?>"></p>
                                    <p class="cep col-md-2"><label>cep</label><input type="text" class="form-control"  name="endereco[cep]" value="<?php echo $end['cep']; ?>"></p>
                                </div>
                            </div>

                            <div class="container">
                                <div class="row">
                                    <p class="bairro col-md-5"><label>bairro</label><input type="text" class="form-control"  name="endereco[bairro]" value="<?php echo $end['bairro']; ?>"></p>
                                    <p class="col-md-3">
                                        <label>estado</label>
                                        <select class="form-control" name=endereco[estado]>
                                            <?php foreach (est::ListaEstado() as $est) { ?>
                                                <?php if (!empty($est['estado'])) { ?> 
                                                    <option 
                                                    <?php
                                                    if ($end['estado'] === $est['id']) {
                                                        echo"selected='selected'";
                                                    }
                                                    ?>
                                                        value="<?php echo $est['id'] ?>"><?php echo $est['estado']; ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                        </select>
                                    </p>
                                    <p class="col-md-4"><label>cidade  <?php echo end::$cidade; ?></label>
                                        <select class="form-control" name=endereco[cidade]>
                                            <?php foreach (cid::ListaCidade() as $cid) { ?>
                                                <?php if (!empty($cid['cidade'])) { ?> 
                                                    <option  
                                                    <?php
                                                    if ($end['cidade'] === $cid['id']) {
                                                        echo"selected='selected'";
                                                    }
                                                    ?>  value="<?php echo $cid['id'] ?>"><?php echo $cid['cidade']; ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                        </select>
                                    </p>
                                </div>
                            </div>
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="radio">
                                            <br><label>manter ativo</label><input type="radio" <?php if ($end['ativo'] == 1) { ?>checked="checked"<?php } ?> name=endereco[ativo] value="1">
                                            <br><label>desativado</label><input type="radio"<?php if ($end['ativo'] != 1) { ?>checked="checked"<?php } ?> name=endereco[ativo] value="0">
                                        </div>
                                    </div>
                                    <p class="col-sm-5"><input class="btn btn-warning" type="submit" value="alterar"></p>
                                </div>
                            </div>
                            <!------------------------------------------------->
                            <!------------------------------------------------->
                            <!------------------------------------------------->





                            <!------------------------------------------------->

                        </form>
                    <?php endforeach; ?>





                </div>






                <div class="tab-pane" id="aba_email" role="tabpanel">
                    <?php
                    foreach (em::EmailCliente(cli::$IdCliente) as $em):
                        echo em::Formulario($em);
                    endforeach;
                    ?>
                </div>







                <div class="tab-pane" id="aba_telefones" role="tabpanel">
                    <?php
                    foreach (tel::Telefone_do_cliente() as $tel):
                        echo tel::Formulario($tel);
                    endforeach;
                    ?>
                </div>



                <div class="tab-pane" id="aba_relacao" role="tabpanel">
                    <?php
                    doc::$documento = cli::$documento;
                    $corretor = doc::relacao_documento();
                    ?>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <br><b>Corretor responsável: <?php echo $corretor['nome']?></b>
                                <br><b>Susep: <?php echo $corretor['documento']?></b>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>