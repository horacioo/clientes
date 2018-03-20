<?php

use Planet1\clientes as cl;
use Planet1\Emails as em;
use Planet1\telefone as tel;
use Planet1\documento as doc;
use Planet1\produto;
use Planet1\indicacoes;
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>
    .row{
        border: 1px solid #b9b9b9;
        padding:29px 0px 0px 0px;
        background-color: #ececec;
        border-radius: 15px 15px 8px 8px;
        margin-bottom: 28px;
        margin-top: 18px;
    }
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
    li{font-size: 11px;}
    h1,h2,h3{
        width: 100%; text-align: center;
        font-size: 20px!important;
    }
</style>

<div class="container-fluid" id="app">
    <h2>{{mensagem}}</h2>    
    <form action="" method="post" name="dados">
        <div class="row">
            <div class="col-lg-3">

                <!--<p><label>id</label><input style="width: 89%; float: right;" id='id' type='text' name=dados[clientes][id] class='form-control'></p>-->
                <!-------->
                <p><label>Nome</label><input style="width: 84%; float: right;" required='required' id='nome' type='text' name=dados[clientes][nome] class='form-control'></p>
                <!-------->
                <p><label>Tipo de pessoa</label>
                    <select name=dados[clientes][tipo_de_pessoa]  style="width: 70%; float: right;" v-model="tipo_de_pessoa" class='form-control'>
                        <option value='f'>fisica</option>
                        <option value='j'>jurídica</option>
                    </select></p>
                <!------->
                <p><label>Sexo</label>
                    <select style="width: 85%; float: right;" name=dados[clientes][sexo] v-model="sexo" class='form-control'>
                        <option value='m'>masculino</option>
                        <option value='f'>feminino</option>
                    </select></p>
                <p><label>Data de Nascimento</label><input style="width: 61%; float: right;" v-model="dataNascimento" required='required' id='nascimento' type='date' name=dados[clientes][dataNascimento] class='form-control'></p>
                <!------->
            </div>

            <div class="col-lg-3">
                <!------->
                <p><label>Cpf</label><input type='text' style="width: 91%; float: right;" v-model="cpf" required='required' id='cpf' name=dados[clientes][cpf] class='form-control'></p>
                <!------->
                <p><label>Rg</label><input type='text' style="width: 91%; float: right;" v-model="rg" required='required' id='rg' name=dados[clientes][rg] class='form-control'></p>
                <!------->
                <p><label>Data de expedição</label><input style="width: 64%; float: right;" v-model="dataExpedicao" required='required' type='date' id='data_de_expedicao' name=dados[clientes][dataExpedicao] class='form-control'></p>
                <!------->    
            </div>

            <div class="col-lg-3">
                <p><label>Documento</label>
                    <select style="width: 75%; float: right;" name=dados[clientes][documento] v-model="documento" class="form-control">
                        <?php foreach (doc::lista_documento() as $li): ?>
                            <option value="<?php echo $li['id'] ?>"> <?php echo $li['documento'] ?></option>
                        <?php endforeach; ?>
                    </select></p>
                <!------->
                <p><label>Telefone</label><input required='required' style="width: 81%; float: right;" v-model="telefone" type='text' name=dados[telefone][telefone][] id='telefone' class='form-control'></p>
                <p><label>referencia</label><input required='required' style="width: 79%; float: right;" v-model="referencia_telefone" type='text' name=dados[telefone][referencia][] id='telefone' class='form-control'></p>
                <!------->
                <p><label>E-mail</label><input required='required' style="width: 85%; float: right;" v-model="email" type='email' id='email' name=dados[email][email][] class='form-control'></p>
                <!------->
                <p><label>endereço</label><input required='required' style="width: 80%; float: right;" v-model="endereco" type='text' id='endereco' name=dados[endereco] class='form-control'></p>
                <!------->
            </div>
            <div class="col-lg-3">
                <label>cliente indicado por:</label><input  class="form-control" name=dados[indicacao][quemIndica] type="text">
            </div>
        </div>
        
       
       
        <div class="row">
            <div class="col-md-3">
                <h2>cadastrar produto desse cliente:</h2>
                <p><label>produto</label>
                    <select class="form-control" type="text" name=dados[produtos][produto]>
                        <?php foreach (produto::ListaProdutos() as $p): ?>
                            <option value="<?php echo $p['id'] ?>"><?php echo $p['produto'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </p>
                <p><label>valor</label><input class="form-control" type="text" name=dados[produtos][valor]></p>
            </div>
            <div class="col-md-3">
                <h2>Cliente ativo?</h2>
                <p>
                    <label>não ativo</label><input type="radio" value="0"  name=dados[produtos][ativo]>
                    <label>ativo</label><input checked="checked" type="radio" value="1" name=dados[produtos][ativo]>
                </p>
            </div>
            <div class="col-md-4">
                <h2>lista de produtos desse cliente:</h2>
                <ul>
                    <li>alidasa</li>
                    <li>alidasa</li>
                </ul>
            </div>
        </div>
        
        <br><input type="submit" value="Salvar" class="btn btn-primary">    
    </form>



    <Component></Component>
</div>   



<script src="<?php echo Vue ?>"></script>
<script>

new Vue({
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
        endereco: ''
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
    /*     * ******************************************** */
    $dados = $_POST['dados'];
    ///new cl();

    cl::$nome           = $_POST['dados']['clientes']['nome'];
    cl::$tipo_de_pessoa = $_POST['dados']['clientes']['tipo_de_pessoa'];
    cl::$sexo           = $_POST['dados']['clientes']['sexo'];
    cl::$cpf            = $_POST['dados']['clientes']['cpf'];
    cl::$rg             = $_POST['dados']['clientes']['rg'];
    cl::$dataNascimento = $_POST['dados']['clientes']['dataNascimento'];
    cl::$dataExpedicao  = $_POST['dados']['clientes']['dataExpedicao'];
    cl::create();
    /*     * ******************************************** */
    foreach ($dados['email']['email'] as $e):
        if (!empty($e)):
            em::$entradaDados = array("email" => $e);
            em::$id_cliente   = cl::$IdCliente;
            em::Create();
        endif;
    endforeach;
    /*     * ******************************************** */
    foreach ($dados['telefone']['telefone'] as $t):
        if (!empty($t)):
            tel::$dados_entrada = array("telefone" => $t);
            tel::$id_cliente    = cl::$IdCliente;
            tel::Create();
        endif;
    endforeach;
    /*     * ******************************************** */
    if (!is_null($dados['indicacao']['quemIndica'])):
        indicacoes::$cliente     = cl::$IdCliente;
        indicacoes::$quemIndicou = $dados['indicacao']['quemIndica']; //dados[indicacao][quemIndica]
        indicacoes::Create();
    endif;
    /*     * ******************************************** */
    produto::$id_cliente = cl::$IdCliente;
    produto::$id_produto = $dados['produtos']['produto'];
    produto::$valor      = $dados['produtos']['valor'];
    produto::$ativo      = $dados['produtos']['ativo'];
    produto::AssociaProdutos();
/* * ******************************************** */
endif;
?>