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

    /*if ($_POST['dados']['email']['email'] != "") {
        em::$id_cliente   = cl::$IdCliente;
        em::$entradaDados = $_POST['dados']['email']['email'];
        em::AssociacaoDeClientes();
    }*/
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
cl::$IdCliente       = "69";
cl::DadosCliente();
/* * ****************** */
tel::$id_cliente     = cl::$IdCliente;
$telefones_clientes  = tel::Telefone_do_cliente();
/* * ****************** */
/*
em::$id_cliente      = cl::$IdCliente;
$emailsCliente       = em::EmailCliente();
*/
/* * ****************** */
tel::$id_cliente     = cl::$IdCliente;
/* * ****************** */
produto::$id_cliente = cl::$IdCliente;
/* * ****************** */
/*
  Planet1\comentario::$id_cliente = cl::$IdCliente;
  $comentarios                    = Planet1\comentario::ComentariosDoCliente();
 */
global $_wp_admin_css_colors
?>

<!-------------------------------------------------------------------->
<!-------------------------------------------------------------------->

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<div class="container-fluid" id="app">

    <!--------------------------------------------------------------------------->

    <form action="" method="post" name="dados">
        <input v-model="id" type="hidden" >
        <!--------------------------------------------------------------------------->





        <!--------------------------------------------------------------------------->
        <div class="container dadosPessoais">
            <div class="row">
                <h2>Editar Cliente</h2> 
                <div class="col-lg-3">
                    <input type="hidden" name=clientes[id] value="<?php echo cl::$IdCliente ?>">
                    <!-------->
                    <p><label>Nome</label><input v-model="nome" style="width: 84%; float: right;" value="<?php echo cl::$nome; ?>" required='required' id='nome' type='text' name=clientes[nome] class='form-control'></p>
                    <hr>
                    <!-------->
                    <p><label>Tipo de pessoa</label>
                        <select name=clientes[tipo_de_pessoa]  v-model="tipo_de_pessoa"   style="width: 70%; float: right;" class='form-control'>
                            <option value='f'>fisica</option>
                            <option value='j'>jurídica</option>
                        </select>
                    </p>
                    <hr>
                    <!------->
                    <p><label>Sexo</label>
                        <select style="width: 85%; float: right;" v-model="sexo" name=clientes[sexo]  class='form-control'>
                            <option value='m'>masculino</option>
                            <option value='f'>feminino</option>
                        </select>
                    </p>
                    <hr>
                    <p><label>Data de Nascimento</label><input v-model="dataNascimento" style="width: 59%; float: right;"  value='<?php echo cl::$dataNascimento; ?>'  required='required' id='nascimento' type='date' name=clientes[dataNascimento] class='form-control'></p>
                    <!------->
                    <hr>
                </div>
                <div class="col-lg-3">
                    <!------->
                    <p><label>Cpf</label><input type='text' v-model="cpf" style="width: 91%; float: right;" value='<?php echo cl::$cpf ?>' required='required' id='cpf' name=clientes[cpf] class='form-control'></p>
                    <hr><!------->
                    <p><label>Rg</label><input type='text' v-model="rg" style="width: 91%;  float: right;" value='<?php echo cl::$cpf ?>' required='required' id='rg' name=clientes[rg] class='form-control'></p>
                    <hr><!------->
                    <p><label>Data de expedição</label><input v-model="dataExpedicao" style="width: 60%; float: right;" value='<?php echo cl::$dataExpedicao ?>' required='required' type='date' id='data_de_expedicao' name=clientes[dataExpedicao] class='form-control'></p>
                    <hr><!------->    
                </div>
                <div class="col-lg-3">
                    <p><label>Documento!!</label>
                        <select style="width: 75%; float: right;" name=clientes[documento] class="form-control">
                            <?php foreach (doc::lista_documento() as $li): ?>
                                <option <?php
                                if (cl::$documento == $li['id']) {
                                    echo" selected='selected'";
                                }
                                ?> value="<?php echo $li['id'] ?>"> 
                                    <?php echo $li['documento'] ?></option>
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
                            <label>Telefone</label><input style="width: 83%; float: right;"  type='text' id='email' class='form-control' name=dados[telefone][telefone][] >
                        </p>


                        <div v-for="item in telefones">
                            <div style="height: auto;overflow: auto; margin-bottom: 2px;">
                                <input style=" margin: 7px 1px 1px 15px;float: left;" checked="checked" type="checkbox"  :value="item.id"  v-on:click="deletaTel(item,$event.target.value)" >
                                <input style="width: 95%; float: right;"  v-on:change="editaTel(item,$event.target.value)" class="form-control" type="text" :value="item.telefone"  name=dados[telefone][telefone][] >
                            </div>
                        </div>

                        <hr>
                        <!------->
                        <p>
                            <label>E-mail</label>
                            <input style="width: 83%; float: right;" v-model="email" v-on:change="criarEmail()" type='email' id='email' name=dados[email][email][] class='form-control'>
                        </p>


                        <div v-for="item in emails">
                            <div style="height: auto;overflow: auto; margin-bottom: 2px;">
                                <input style=" margin: 7px 1px 1px 15px;float: left;" checked="checked" type="checkbox"  :value="item.id" @click="deletaEmail(item)" >
                                <input style="width: 95%; float: right;" v-on:change="editaEmail(item,$event.target.value)" class="form-control" type="text" :value="item.email"  name=dados[email][email][] >
                            </div>
                        </div>


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
                    <?php $produtos_listax = produto::ListaProdutos(); //print_r(produto::ProdutoDoCliente());     ?>
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
                    <input type="hidden" v-model="id_cliente" value="<?php echo cl::$IdCliente; ?>">
                    <textarea v-model="caixaComentario" class="form-control textarea" name=dados[comentarios][comentario]></textarea>
                    <div @click="CadComent()" style="    border: 1px solid #8e8e8e;
                          display: inline-block;
                          padding: 5px;
                          background-color: #dadada;
                          color: #0066b1;">salvar comentário</div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div>

                        <div v-for="item in comentarios" class="assinatura comentarios outrosComentarios col-lg-12">
                            Comentario postado por {{item.postadoPor}} no dia {{item.data}} <br>
                            {{item.comentario}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--------------------------------------------------------------------------->
        <br><input type="submit" value="Salvar" class="btn btn-primary">  
        <!--------------------------------------------------------------------------->
    </form>
    <p v-if="processando" style="
       align-content: center;
       text-align: center;
       position: fixed;
       width: 100%;
       top: 0px;
       z-index: 4;
       background-color: rgba(0, 0, 0, 0.65);
       height: 100%;
       padding-top: 15%;
       margin-left: -35px;">
        <img src=" <?php echo plugin_dir_url('clientes') . "clientes/include/arquivos/imagens/load.gif" ?>">
    </p>
</div>   
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>
<script src="<?php echo Vue ?>"></script>
<script >

new Vue({
    el: "#app",
    data: {
        id: "",
        nome: "<?php echo cl::$nome ?>",
        tipo_de_pessoa: "<?php echo cl::$tipo_de_pessoa ?>",
        sexo: "<?php echo cl::$sexo ?>",
        dataNascimento: "<?php echo cl::$dataNascimento ?>",
        dataExpedicao: "<?php echo cl::$dataExpedicao; ?>",
        documento: "<?php echo cl::$documento ?>",
        indicacao: "<?php echo cl::$indicado; ?>",
        pessoaQueIndicou: "",
        telefone: "",
        caixaComentario: "",
        id_cliente: "<?php echo cl::$IdCliente ?>",
        cpf: "<?php echo cl::$cpf; ?>",
        rg: "<?php echo cl::$rg; ?>",
        documento: "<?php echo cl::$documento; ?>",
        endereco: "<?php echo "%%"; ?>",
        comentarios: ["a informacao", "chuva"],
        emails: [], //emails:<?php echo json_encode($emailsCliente); ?>,
        telefones: [], //<?php echo json_encode($telefones_clientes) ?>,
        refEmail: "",
        email: "",
        processando: false,
        stand: true,

    },
    watch: {},
    methods: {
        /***********************************************************/
        criarEmail: function () {
            var Url;
            var App;
            var ItemSv;
            App = this;
            App.emails = '';
            App.processando = true;
            ItemSv = {
                "cliente": App.id_cliente,
                "email": App.email,
                "comando": "salva",
            };
            var dadosSv = btoa(JSON.stringify(ItemSv));
            Url = 'http://localhost/corretorawp/wp-content/plugins/clientes/api/emailsAdm.php?dados=' + dadosSv + '';
            axios.get(Url).then(function (response) {
                App.emails = response.data;
                console.log(response.data);
                App.processando = false,
                        App.email = '';
            });
        },
        /***********************************************************/
        deletaEmail: function (item) {
            var Url;
            var App;
            var ItemdE;
            App = this;
            App.processando = true;
            App.emails = '';
            ItemdE = {
                "cliente": App.id_cliente,
                "id": item.id,
                "comando": "deletar"
            }
            var dadosDE = btoa(JSON.stringify(ItemdE));
            Url = 'http://localhost/corretorawp/wp-content/plugins/clientes/api/emailsAdm.php?dados=' + dadosDE + '';
            axios.get(Url).then(function (response) {
                console.log(Url);
                App.processando = false;
                App.emails = response.data
            }); //console.log(Url);
        },
        /***********************************************************/
        editaEmail: function (item, dados) {
            var Url;
            var App;
            var Item;
            App = this;
            App.processando = true;
            ItemEE = {
                'cliente': App.id_cliente,
                'email': dados,
                'id': item.id,
                'comando': "editar"
            };
            App.emails = "";
            var dadosEEm = btoa(JSON.stringify(ItemEE));
            Url = 'http://localhost/corretorawp/wp-content/plugins/clientes/api/emailsAdm.php?dados=' + dadosEEm + '';
            console.log('\n \r' + dados);
            console.log('\n \r' + Url);
            axios.get(Url).then(function (response) {
                App.processando = false;
                App.emails = response.data;
            });
        },
        /***********************************************************/
        editaTel: function (item, dados) {
            console.log("telefone novo " + dados);
            var item = {
                "cliente": this.id_cliente,
                "telefone": dados,
                "id_telefone": item.id,
                "comando": "editar"
            };
            console.log("\n \r" + item.telefone);
            var dados = btoa(JSON.stringify(item));
            var url = "http://localhost/corretorawp/wp-content/plugins/clientes/api/telAdm.php?dados=" + dados + " ";
            axios.get(url).then(function (response) {
                this.telefones = response.data
            });
            console.log(url);
        },
        /**********************************************/
        deletaTel: function (item, dados) {
            var App;
            App = this;
            App.telefones = [];
            var item = {
                "cliente": this.id_cliente,
                "telefone": dados,
                "id_telefone": item.id,
                "comando": "deletar"
            };
            var dados = btoa(JSON.stringify(item));
            var url = "http://localhost/corretorawp/wp-content/plugins/clientes/api/telAdm.php?dados=" + dados + " ";
            console.log(url);
            axios.get(url).then(function (response) {
                App.telefones = response.data; //[{"telefone": 222, "id": 2}]
            },
                    );
        },
        /**********************************************/
        /*********/
        CadComent: function () {
            var App;
            App = this;
            var url = "http://localhost/corretorawp/wp-content/plugins/clientes/api/comentarios.php?acao=salva&comentario=" + App.caixaComentario + "&cliente=" + App.id_cliente + "";
            axios.get(url).then(function (response) {
                console.log(url);
                App.comentarios = response.data;
                App.caixaComentario = "";
            })
        }
    },
    created: function () {
        var App;
        App = this;
        /*********************************************************************/
        var dadosx = {
            "cliente": App.id_cliente,
            "comando": "listar"
        };
        var dados = btoa(JSON.stringify(dadosx));
        var url = 'http://localhost/corretorawp/wp-content/plugins/clientes/api/emailsAdm.php?dados=' + dados + '';
        axios.get(url).then(function (response) {
            console.log(url);
            App.emails = response.data;
        });
        /*****************************************/
        var dadostel = {
            "cliente": 69,
            "comando": "lista"
        };
        var dadosy = btoa(JSON.stringify(dadostel));
        axios.get('http://localhost/corretorawp/wp-content/plugins/clientes/api/telAdm.php?dados=' + dadosy + '').then(
                function (response) {
                    console.log("acesso a pagina" + 'http://localhost/corretorawp/wp-content/plugins/clientes/api/telAdm.php?dados=' + dadosy + '');
                    App.telefones = response.data;
                });
        /*****************************************/
        axios.get('http://localhost/corretorawp/wp-content/plugins/clientes/api/comentarios.php?acao=lista&cliente=' + App.id_cliente + '').then(function (response) {
            App.comentarios = [{comentario: "teste apenas"}];
            App.comentarios = response.data;
        })
    },
});
</script>



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
