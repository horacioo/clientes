<?php

use Planet1\clientes as cl;
use Planet1\Emails as em;
use Planet1\telefone as tel;
use Planet1\documento as doc;
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>
    label{
        font-size: 11px;
        margin-bottom: 1px!important;
        margin-top: 8px;
    }
    input, select{
        font-size: 12px!important;
        padding: 5px!important;
    }
    select{height: 30px!important;}
    p{margin-bottom: 23px!important;}

</style>

<div class="container-fluid" id="app">
    <h2>{{mensagem}}</h2>    
    <form action="" method="post" name="dados">
        <div class="row">
            <div class="col-lg-4">

                <p><label>id</label><input style="width: 89%; float: right;" id='id' type='text' name=dados[clientes][id] class='form-control'></p>
                <p><label>Nome</label><input style="width: 84%; float: right;" required='required' id='nome' type='text' name=dados[clientes][nome] class='form-control'></p>
                <!-------->
                <p><label>Tipo de pessoa</label>
                    <select name=dados[clientes][tipo_de_pessoa  style="width: 76%; float: right;" v-model="tipo_de_pessoa" class='form-control'>
                        <option value='f'>fisica</option>
                        <option value='j'>jurídica</option>
                    </select></p>
                <!------->
                <p><label>Sexo</label>
                    <select style="width: 91%; float: right;" name=dados[clientes][sexo] v-model="sexo" class='form-control'>
                        <option value='m'>masculino</option>
                        <option value='f'>feminino</option>
                    </select></p>
                <p><label>Data de Nascimento</label><input style="width: 70%; float: right;" v-model="dataNascimento" required='required' id='nascimento' type='date' name=dados[clientes][dataNascimento] class='form-control'></p>
                <!------->


            </div>

            <div class="col-lg-4">
                <!------->
                <p><label>Cpf</label><input type='text' style="width: 91%; float: right;" v-model="cpf" required='required' id='cpf' name=dados[clientes][cpf] class='form-control'></p>
                <!------->
                <p><label>Rg</label><input type='text' style="width: 91%; float: right;" v-model="rg" required='required' id='rg' name=dados[clientes][rg] class='form-control'></p>
                <!------->
                <p><label>Data de expedição</label><input style="width: 73%; float: right;" v-model="dataExpedicao" required='required' type='date' id='data_de_expedicao' name=dados[clientes][dataExpedicao] class='form-control'></p>
                <!------->    
            </div>

            <div class="col-lg-4">
                <p><label>Documento</label>
                    <select style="width: 80%; float: right;" name=dados[clientes][documento] v-model="documento" class="form-control">
                        <?php foreach (doc::lista_documento() as $li): ?>
                            <option value="<?php echo $li['id'] ?>"> <?php echo $li['documento'] ?></option>
                        <?php endforeach; ?>
                    </select></p>
                <!------->
                <p><label>Telefone</label><input required='required' style="width: 87%; float: right;" v-model="telefone" type='text' name=dados[telefone][telefone][] id='telefone' class='form-control'></p>
                <p><label>referencia</label><input required='required' style="width: 84%; float: right;" v-model="referencia_telefone" type='text' name=dados[telefone][referencia][] id='telefone' class='form-control'></p>
                <!------->
                <p><label>E-mail</label><input required='required' style="width: 87%; float: right;" v-model="email" type='email' id='email' name=dados[email][email][] class='form-control'></p>
                <!------->
                <p><label>endereço</label><input required='required' style="width: 85%; float: right;" v-model="endereco" type='text' id='email' name=dados[email][email][] class='form-control'></p>
                <!------->
            </div>
        </div>
        <hr>
        <div class="row">


        </div>
        <hr>
        <br><input type="submit" value="Salvar" class="btn btn-primary">    
    </form>




</div>   



<script src="<?php echo Vue; ?>" ></script>
<script>
var app = new Vue({
    el: '#app',
    data: {
        mensagem: "Cadastrar novo cliente",
        id: '',
        nome: '',
        tipo_de_pessoa: '',
        sexo: '',
        cpf: '',
        rg: '',
        dataExpedicao: '',
        dataNascimento: '',
        documento: '',
        email: '',
        telefone: '',
        referencia_telefone: '',
        ativo: '',
        produto: '',
        endereco: '',
    }
});
</script>
<!------------------------------------------------------------>
<!------------------------------------------------------------>
<!------------------------------------------------------------>
<!------------------------------------------------------------>
<!------------------------------------------------------------>
<!------------------------------------------------------------>



<?php
if (isset($_POST['dados'])):

    $dados             = $_POST['dados'];
    new cl();
    cl::create();
    
    foreach ($dados['email']['email'] as $e):
        if (!empty($e)):
            em::$entradaDados = array("email" => $e);
            em::$id_cliente   = cl::$IdCliente;
            em::Create();
        endif;
    endforeach;

    foreach ($dados['telefone']['telefone'] as $t):
        if (!empty($t)):
            tel::$dados_entrada = array("telefone" => $t);
            tel::$id_cliente    = cl::$IdCliente;
            tel::Create();
        endif;
    endforeach;

endif;
?>