<!-------------------------------------------------------------------->
<!-------------------------------------------------------------------->
<?php

         use Planet1\clientes as cl;
         use Planet1\Emails as em;
         use Planet1\telefone as tel;
         use Planet1\documento as doc;
         use Planet1\produto;
         use Planet1\indicacoes;

/*          * ****************** */
         cl::$IdCliente       = 6445;
         cl::DadosCliente();
         /*          * ****************** */
         tel::$id_cliente     = cl::$IdCliente;
         tel::Telefone_do_cliente();
         /*          * ****************** */
         em::$id_cliente      = cl::$IdCliente;
         $emailsCliente       = em::EmailCliente();
         /*          * ****************** */
         tel::$id_cliente     = cl::$IdCliente;
         /*          * ****************** */
         produto::$id_cliente = cl::$IdCliente;
         /*          * ****************** */
         global $_wp_admin_css_colors
?>
<?php
         print_r($_POST['dados']);
?>
<!-------------------------------------------------------------------->
<!-------------------------------------------------------------------->

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>
    .row{
        font-family: arial;
        font-size: 11px;
        line-height: 26px;
        font-weight: 400;
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
    .listaClientes{
        position: absolute;
        z-index: 2;
        max-width: 100%;
        width: 500px;
    }
    .listaClientes li{
        border: 1px solid #c7c7c7;
        background-color: #f1f1f1;
        padding: 6px;
        margin-bottom: 1px;
        text-transform: capitalize;
    }
    .listaClientes li:hover{
        background-color: #a9d8ff;;
    }
    table{width: 100%;}
    tr{}
    td{
        border: 1px solid #c7c7c7;
        background-color: #efefef;
        padding: 1px 10px 1px 10px;
        text-align: center;
    }
</style>

<div class="container-fluid" id="app">

    <!--------------------------------------------------------------------------->
    <h2>Editar Cliente</h2>    
    <form action="" method="post" name="dados">
        <input v-if="edit" v-model="id" type="hidden" >
        <!--------------------------------------------------------------------------->





        <!--------------------------------------------------------------------------->
        <div class="row">
            <div class="col-lg-3">
                <!-------->
                <p><label>Nome</label><input style="width: 84%; float: right;" value="<?php echo cl::$nome; ?>" required='required' id='nome' type='text' name=dados[clientes][nome] class='form-control'></p>
                <hr>
                <!-------->
                <p><label>Tipo de pessoa</label>
                    <select name=dados[clientes][tipo_de_pessoa]  style="width: 70%; float: right;" v-model="tipo_de_pessoa" class='form-control'>
                        <option value='f'>fisica</option>
                        <option value='j'>jurídica</option>
                    </select>
                </p>
                <hr>
                <!------->
                <p><label>Sexo</label>
                    <select style="width: 85%; float: right;"  name=dados[clientes][sexo] v-model="sexo" class='form-control'>
                        <option value='m'>masculino</option>
                        <option value='f'>feminino</option>
                    </select>
                </p>
                <hr>
                <p><label>Data de Nascimento</label><input style="width: 61%; float: right;" v-model="dataNascimento" value='<?php echo cl::$dataNascimento; ?>'  required='required' id='nascimento' type='date' name=dados[clientes][dataNascimento] class='form-control'></p>
                <!------->
                <hr>
            </div>


            <div class="col-lg-3">
                <!------->
                <p><label>Cpf</label><input type='text' style="width: 91%; float: right;" value='<?php echo cl::$cpf ?>' v-model="cpf" required='required' id='cpf' name=dados[clientes][cpf] class='form-control'></p>
                <hr><!------->
                <p><label>Rg</label><input type='text' style="width: 91%;  float: right;" value='<?php echo cl::$cpf ?>' v-model="rg" required='required' id='rg' name=dados[clientes][rg] class='form-control'></p>
                <hr><!------->
                <p><label>Data de expedição</label><input style="width: 64%; float: right;" value='<?php echo cl::$dataExpedicao ?>' v-model="dataExpedicao" required='required' type='date' id='data_de_expedicao' name=dados[clientes][dataExpedicao] class='form-control'></p>
                <hr><!------->    
            </div>


            <div class="col-lg-3">


                <p><label>Documento!!</label>
                    <select style="width: 75%; float: right;" name=dados[clientes][documento] v-model="documento" class="form-control">
                        <?php foreach (doc::lista_documento() as $li): ?>
                                     <option <?php
                                     if (cl::$documento == $li['id']) {
                                         echo" selected='selected'";
                                     }
                                     ?> value="<?php echo $li['id'] ?>"> <?php echo $li['documento'] ?></option>
                                     <?php endforeach; ?>
                    </select>
                </p>
                <hr>
                <!------->

                <hr>
                <span >    


                    <!------->
                    <p >
                        <label>Telefone</label><input style="width: 83%; float: right;" v-model="telefone" type='text' id='email' class='form-control' name=dados[telefone][telefone][] >
                    </p>
                    <?php foreach (tel::Telefone_do_cliente() as $t): ?>
                                 <p >
                                     <label>Telefone</label><input value="<?php echo $t['telefone']; ?>" required='required' style="width: 83%; float: right;" v-model="telefone" type='text' id='email' class='form-control' name=dados[telefone][telefone][] >
                                 </p>
                             <?php endforeach; ?>
                    <hr>             
                    <!------->

                    <!------->
                    <p>
                        <label>E-mail</label>
                        <input style="width: 83%; float: right;" v-model="email" type='email' id='email' name=dados[email][email][] class='form-control'>
                    </p>
                    <?php foreach ($emailsCliente as $e): ?>
                                 <p>
                                     <label>E-mail</label><input value="<?php echo $e['email'] ?>" required='required' style="width: 83%; float: right;" v-model="email" type='email' id='email' name=dados[email][email][] class='form-control'>
                                 </p>
                             <?php endforeach; ?>
                    <!------->
                    <hr>
                </span>








                <!------->
                <p><label>endereço</label><input style="width: 80%; float: right;" v-model="endereco" type='text' id='endereco' name=dados[endereco] class='form-control'></p>
                <!------->
            </div>
            <div class="col-lg-3">
                indicado por <input type="text" v-model="indicacao" @keyup="indicacaoFcn()" class="form-control">
                <ul>
                    <li v-for="item in pessoaQueIndicou">{{item.nome}}\{{item.cpf}} <br> <input type="hidden"  :value="item.id"  name=dados[indicacao][quemIndica] ></li>
                </ul>
                <!---name=dados['indicacao']['quemIndica']---->
            </div>
        </div>
        <!--------------------------------------------------------------------------->











        <!--------------------------------------------------------------------------->
        <div class="row"  >
            <div class="col-md-4">
                <h2>cadastrar novo produto para esse cliente:</h2>
                <p><label>produto</label>
                    <select class="form-control" type="text" name=dados[MeusProdutos][0][produto]>
                        <?php foreach (produto::ListaProdutos() as $p): ?><!---[MeusProdutos]-->
                                     <option value="<?php echo $p['id'] ?>"><?php echo $p['produto'] ?></option>
                                 <?php endforeach; ?>
                    </select>
                </p>
                <p><label>valor</label><input class="form-control" type="text" name=dados[MeusProdutos][0][valor]></p>
                <p><label>comissão</label><input class="form-control" type="text" name=dados[MeusProdutos][0][comissao]></p>
            </div>
            <div class="col-md-2">
                <h2>Cliente ativo?</h2>
                <p>
                    <label>não ativo</label><input type="radio" value="0"  name=dados[MeusProdutos][][ativo]>
                    <label>ativo</label><input checked="checked" type="radio" value="1" name=dados[MeusProdutos][0][ativo]>
                </p>
            </div>
            <div class="col-md-6">
                <h3>produtos </h3>
                <?php print_r(produto::ProdutoDoCliente()); ?>
                <table>
                    <tr>
                        <td></td>
                        <td>ativo</td>
                        <td>produto</td>
                        <td>valor do produto</td>
                        <td>comissao</td>
                        <td>total</td>
                        <td>data</td>
                    </tr>
                    <?php
                             foreach (produto::ProdutoDoCliente() as $p):
                                 echo"<tr>";
                                 echo"<td>"
                                 . "<input name=dados[MeusProdutos][" . $p['produtos'] . "] type='checkbox' checked='checked' values='" . $p['produtos'] . "' />"
                                 . "</td>";
                                 echo"<td>"
                                 . "<select name=dados[MeusProdutos][" . $p['produtos'] . "][ativo]> "
                                 . "<option value='1'>ativo</option>"
                                 . "<option value='0' >inativo</option>"
                                 . "</select>";
                                 echo"</td>"; /*  
                                  * 
                                  *                                 * " . $p['ativo'] . "* */
                               //echo"<td><input name=dados[MeusProdutos][" . $p['produtos'] . "][produto] value='" . $p['produto'] . "'></td>";
                                 
                                 echo"<td>"
                                 . "<select name=dados[MeusProdutos][" . $p['produtos'] . "][produto]> "
                                 . "<option value='1'>ativo</option>"
                                 . "</select>";
                                 echo"</td>"; 
                                 
                                 
                                 echo"<td><input name=dados[MeusProdutos][" . $p['produtos'] . "][valor] value='" . $p['valor'] . "'></td>";
                                 echo"<td><input name=dados[MeusProdutos][" . $p['produtos'] . "][comissao] value='" . $p['comissao'] . "'></td>";
                                 echo"<td>" . $p['total'] . "</td>";
                                 echo"<td>" . date("d-m-Y", strtotime($p['data'])) . "</td>";
                                 echo"</tr>";
                             endforeach;
                    ?>    
                </table>
            </div>
        </div>
        <!--------------------------------------------------------------------------->



        <br><input type="submit" value="Salvar" class="btn btn-primary">  
        <nome-info></nome-info>
        <!--------------------------------------------------------------------------->

    </form>
</div>   
