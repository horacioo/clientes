<!-------------------------------------------------------------------->
<!-------------------------------------------------------------------->
<?php

use Planet1\clientes as cl;
use Planet1\Emails as em;
use Planet1\telefone as tel;
use Planet1\documento as doc;
use Planet1\produto;
use Planet1\indicacoes;
?>



<?php
/* * ******************************************************** */
cl::Update();
$cliente_id    = $_POST['clientes']['id'];
cl::$IdCliente = $cliente_id;
/* * ******************************************************** */


if (is_array($_POST['dados']['MeusProdutos'])):

    $produtosCliente       = $_POST['dados']['MeusProdutos'];
    produto::$dadosEntrada = $produtosCliente;
    produto::$id_cliente   = cl::$IdCliente;
    produto::AssociacaoDeClientes();
    /*     * ******************************************************** */

    if ($_POST['dados']['telefone']['telefone'] != "") {
        tel::$id_cliente    = cl::$IdCliente;
        tel::$dados_entrada = $_POST['dados']['telefone']['telefone'];
        tel::AssociacaoDeClientes();
    }
    /*     * ******************************************************** */

    if ($_POST['dados']['email']['email'] != "") {
        em::$id_cliente   = cl::$IdCliente;
        em::$entradaDados = $_POST['dados']['email']['email'];
        em::AssociacaoDeClientes();
    }
    /*     * ******************************************************** */


    if ($_POST['dados']['comentarios']['comentario'] != "") {
        Planet1\comentario::$id_cliente = cl::$IdCliente;
        Planet1\comentario::$comentario = $_POST['dados']['comentarios']['comentario'];
        Planet1\comentario::$postadoPor = 5;
        Planet1\comentario::SalvaComentario();
    }

/* * ******************************************************** */

endif;
?>



<?php
/* * ****************** */
cl::$IdCliente                  = "69";
cl::DadosCliente();
/* * ****************** */
tel::$id_cliente                = cl::$IdCliente;
tel::Telefone_do_cliente();
/* * ****************** */
em::$id_cliente                 = cl::$IdCliente;
$emailsCliente                  = em::EmailCliente();
/* * ****************** */
tel::$id_cliente                = cl::$IdCliente;
/* * ****************** */
produto::$id_cliente            = cl::$IdCliente;
/* * ****************** */
Planet1\comentario::$id_cliente = cl::$IdCliente;
$comentarios                    = Planet1\comentario::ComentariosDoCliente();
global $_wp_admin_css_colors
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
    .inputClass{
        background-color: #ff000000;
        height: 24px;
        border: none;
        width: 50px;
        text-align: center;
    }

    .textarea{  
        height: 251px;
        color: #777777!important;
        margin-bottom: 23px!important;
        font-size: 14px!important;
    }
    .comentarios{
        border: 1px solid #cecece;
        margin-bottom: 1px;
        padding: 17px 1px 17px 1px;
        background-color: whitesmoke;
        color: #8c8c8c;
    }
    .dados_contato, .produtos, .dadosPessoais,.quadroComentarios {
        /*border: 0px solid red;*/
        margin-top: 2px;
        padding: 53px 21px 37px 21px;
        border-bottom: 1px solid #ababab;
        margin-top: 2px;
        padding: 53px 21px 37px 21px;
        margin-bottom: 9px;
    }
</style>

<div class="container-fluid" id="app">

    <!--------------------------------------------------------------------------->

    <form action="" method="post" name="dados">
        <input v-if="edit" v-model="id" type="hidden" >
        <!--------------------------------------------------------------------------->





        <!--------------------------------------------------------------------------->
        <div class="container dadosPessoais">
            <div class="row">
                <h2>Editar Cliente</h2> 
                <div class="col-lg-3">
                    <input type="hidden" name=clientes[id] value="<?php echo cl::$IdCliente ?>">
                    <!-------->
                    <p><label>Nome</label><input style="width: 84%; float: right;" value="<?php echo cl::$nome; ?>" required='required' id='nome' type='text' name=clientes[nome] class='form-control'></p>
                    <hr>
                    <!-------->
                    <p><label>Tipo de pessoa</label>
                        <select name=clientes[tipo_de_pessoa]  style="width: 70%; float: right;" v-model="tipo_de_pessoa" class='form-control'>
                            <option value='f'>fisica</option>
                            <option value='j'>jurídica</option>
                        </select>
                    </p>
                    <hr>
                    <!------->
                    <p><label>Sexo</label>
                        <select style="width: 85%; float: right;"  name=clientes[sexo] v-model="sexo" class='form-control'>
                            <option value='m'>masculino</option>
                            <option value='f'>feminino</option>
                        </select>
                    </p>
                    <hr>
                    <p><label>Data de Nascimento</label><input style="width: 59%; float: right;" v-model="dataNascimento" value='<?php echo cl::$dataNascimento; ?>'  required='required' id='nascimento' type='date' name=clientes[dataNascimento] class='form-control'></p>
                    <!------->
                    <hr>
                </div>
                <div class="col-lg-3">
                    <!------->
                    <p><label>Cpf</label><input type='text' style="width: 91%; float: right;" value='<?php echo cl::$cpf ?>' v-model="cpf" required='required' id='cpf' name=clientes[cpf] class='form-control'></p>
                    <hr><!------->
                    <p><label>Rg</label><input type='text' style="width: 91%;  float: right;" value='<?php echo cl::$cpf ?>' v-model="rg" required='required' id='rg' name=clientes[rg] class='form-control'></p>
                    <hr><!------->
                    <p><label>Data de expedição</label><input style="width: 60%; float: right;" value='<?php echo cl::$dataExpedicao ?>' v-model="dataExpedicao" required='required' type='date' id='data_de_expedicao' name=clientes[dataExpedicao] class='form-control'></p>
                    <hr><!------->    
                </div>
                <div class="col-lg-3">
                    <p><label>Documento!!</label>
                        <select style="width: 75%; float: right;" name=clientes[documento] v-model="documento" class="form-control">
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

                    <!------->
                    <p><label>endereço</label><input style="width: 80%; float: right;" v-model="endereco" type='text' id='endereco' name=dados[endereco] class='form-control'></p>
                    <!------->
                </div>
                <div class="col-lg-3">
                    indicado por <input type="text" v-model="indicacao" @keyup="indicacaoFcn()" class="form-control">
                    <ul>
                        <li v-for="item in pessoaQueIndicou">{{item.nome}}\{{item.cpf}} <br> <input type="hidden"  :value="item.id"  name=clientes[indicado] ></li>
                    </ul>
                    <!---name=dados['indicacao']['quemIndica']---->
                    <label>membro da equipe que atendeu este cliente:</label><input type="text"  class="form-control" >


                </div>
            </div>
        </div>
        <!--------------------------------------------------------------------------->

        <div class="container dados_contato">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Dados de contato</h2>
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
                </div>
            </div>
        </div>





        <!--------------------------------------------------------------------------->
        <div class="container produtos">
            <div class="row"  >
                <div class="col-md-3">
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
                        <label>não ativo</label><input checked="checked" type="radio" value="0"  name=dados[MeusProdutos][0][ativo]>
                        <label>ativo</label><input  type="radio" value="1" name=dados[MeusProdutos][0][ativo]>
                    </p>
                </div>
                <div class="col-md-7">
                    <h3>produtos </h3>
                    <?php $produtos_listax = produto::ListaProdutos(); //print_r(produto::ProdutoDoCliente());   ?>
                    <table>
                        <tr>
                            <td>ativo</td>
                            <td>produto</td>
                            <td>valor do produto</td>
                            <td>comissao</td>
                            <td>total</td>
                            <td>data</td>
                        </tr>
                        <?php
                        $linha           = 0;
                        foreach (produto::ProdutoDoCliente() as $p): $linha++;
                            echo"<tr>";
                            echo"<td>"
                            . "<select name=dados[MeusProdutos][" . $linha . "][ativo]> "
                            . "<option value='1'>ativo</option>"
                            . "<option value='0' >inativo</option>"
                            . "</select>";
                            echo"</td>";
                            //echo"<td><input name=dados[MeusProdutos][" . $linha. "][produto] value='" . $p['produto'] . "'></td>";
                            echo"<td>";
                            echo "<select name = dados[MeusProdutos][" . $linha . "][produto]> ";
                            foreach ($produtos_listax as $pro):
                                echo "<option value='" . $pro['id'] . "'>" . $pro['produto'] . "</option>";
                            endforeach;
                            echo "</select>";
                            echo"</td>";
                            echo"<td><input class='inputClass'  name=dados[MeusProdutos][" . $linha . "][valor] value='" . $p['valor'] . "'></td>";
                            echo"<td><input class='inputClass'  name=dados[MeusProdutos][" . $linha . "][comissao] value='" . $p['comissao'] . "'></td>";
                            echo"<td>" . $p['total'] . " </td>";
                            echo"<td>" . date("d-m-Y", strtotime($p['data'])) . "</td>";
                            echo"</tr>";
                        endforeach;
                        ?>    
                    </table>

                </div> <hr>
            </div>
        </div>
        <!--------------------------------------------------------------------------->








        <!--------------------------------------------------------------------------->
        <div class="container quadroComentarios ">
            <div class="row" id="comentario">
                <div class="col-lg-12 comentario">
                    <textarea class="form-control textarea" name=dados[comentarios][comentario]></textarea>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div>
                        <?php foreach ($comentarios as $c): ?>
                            <div>
                                <div class="assinatura comentarios outrosComentarios col-lg-12"><?php echo date("d/m/Y", strtotime($c['data'])) ?> as <?php echo date("H:i:s", strtotime($c['data'])) ?> por Fabiana 
                                    <div>
                                        <?php echo $c['comentario']; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <!--------------------------------------------------------------------------->
        <br><input type="submit" value="Salvar" class="btn btn-primary">  
        <nome-info></nome-info>
        <!--------------------------------------------------------------------------->

    </form>
</div>   
