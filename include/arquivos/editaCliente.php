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

//$produtosCliente = $_POST['dados']['MeusProdutos'];
///print_r($produtosCliente);

/*
  produto::$dadosEntrada = $produtosCliente;
  produto::$id_cliente   = cl::$IdCliente;
  produto::AssociacaoDeClientes();
 */
/* * ******************************************************** */

/* if ($_POST['dados']['telefone']['telefone'] != "") {
  tel::$id_cliente    = cl::$IdCliente;
  tel::$dados_entrada = $_POST['dados']['telefone']['telefone'];
  tel::AssociacaoDeClientes();
  } */
/* * ******************************************************** */

/* if ($_POST['dados']['email']['email'] != "") {
  em::$id_cliente   = cl::$IdCliente;
  em::$entradaDados = $_POST['dados']['email']['email'];
  em::AssociacaoDeClientes();
  } */
/* * ******************************************************** */


/* if ($_POST['dados']['comentarios']['comentario'] != "") {
  Planet1\comentario::$id_cliente = cl::$IdCliente;
  Planet1\comentario::$comentario = $_POST['dados']['comentarios']['comentario'];
  Planet1\comentario::$postadoPor = 5;
  Planet1\comentario::SalvaComentario();
  } */

/* * ******************************************************** */

endif;
?>



<?php
/* * ****************** */
//cl::$IdCliente       = "69";
//cl::DadosCliente();
/* * *********************** */
//tel::$id_cliente     = cl::$IdCliente;
/* * ****************** */
//produto::$id_cliente = cl::$IdCliente;
/* * ********************* */
?>
<?php
global $_wp_admin_css_colors;
$estilo     = get_user_option('admin_color');
$estilo_css = $_wp_admin_css_colors[$estilo]->colors;
$cor0       = $estilo_css[0];
$cor1       = $estilo_css[1];
$cor2       = $estilo_css[2];
$cor3       = $estilo_css[3];
?>

<!-------------------------------------------------------------------->
<!-------------------------------------------------------------------->

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<div class="container-fluid" id="app">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">




                <p><label>pesquise um cliente</label><input type="text" v-on:click="mostraLista()" v-on:keyup="PesquisaCliente()" class="form-control" v-model="pesquisaDeCliente" ></p>
                <ul v-if="listaClientesPesquisadosDisplay" style=" position: absolute;
                    background-color: white;
                    z-index: 2;
                    padding: 20px;
                    border: 1px solid #bbbbbb;
                    top: 56px;
                    width: 97%;">
                    <li v-if="" v-for="item in listaClientesPesquisados" v-on:click="chamaCliente(item)">{{item.nome}}  </li>
                </ul>


            </div>
        </div>
    </div>
    <!--------------------------------------------------------------------------->

    <form action="" method="post" name="dados">
        <input v-model="id" type="hidden" >
        <input type="hidden" v-model="id_cliente" value="<?php echo cl::$IdCliente; ?>">
        <!--------------------------------------------------------------------------->
        <!--------------------------------------------------------------------------->
        <div class="container dadosPessoais">
            <div class="row">
                <h2>Editar dados de {{nome}}</h2> 
                <div class="col-lg-3">
                    <input type="hidden" name=clientes[id] value="<?php echo cl::$IdCliente ?>">
                    <!-------->
                    <p><label>Nome</label><input v-change="salvaDadosCliente()" v-model="nome" style="width: 84%; float: right;" value="<?php echo cl::$nome; ?>" required='required' id='nome' type='text' name=clientes[nome] class='form-control'></p>
                    <hr>
                    <!-------->
                    <p><label>Tipo de pessoa</label>
                        <select name=clientes[tipo_de_pessoa]  v-change="salvaDadosCliente()"  v-model="tipo_de_pessoa"   style="width: 70%; float: right;" class='form-control'>
                            <option value='f'>fisica</option>
                            <option value='j'>jurídica</option>
                        </select>
                    </p>
                    <hr>
                    <!------->
                    <p><label>Sexo</label>
                        <select style="width: 85%; float: right;"  v-change="salvaDadosCliente()"  v-model="sexo" name=clientes[sexo]  class='form-control'>
                            <option value='m'>masculino</option>
                            <option value='f'>feminino</option>
                        </select>
                    </p>
                    <hr>
                    <p><label>Data de Nascimento</label><input  v-change="salvaDadosCliente()"  v-model="dataNascimento" style="width: 59%; float: right;"  value='<?php echo cl::$dataNascimento; ?>'  required='required' id='nascimento' type='date' name=clientes[dataNascimento] class='form-control'></p>
                    <!------->
                    <hr>
                </div>
                <div class="col-lg-3">
                    <!------->
                    <p><label>Cpf</label><input v-change="salvaDadosCliente()"  type='text' v-model="cpf" style="width: 91%; float: right;" value='<?php echo cl::$cpf ?>' required='required' id='cpf' name=clientes[cpf] class='form-control'></p>
                    <hr><!------->
                    <p><label>Rg</label><input type='text' v-change="salvaDadosCliente()"  v-model="rg" style="width: 91%;  float: right;" value='<?php echo cl::$cpf ?>' required='required' id='rg' name=clientes[rg] class='form-control'></p>
                    <hr><!------->
                    <p><label>Data de expedição</label><input v-change="salvaDadosCliente()"  v-model="dataExpedicao" style="width: 60%; float: right;" value='<?php echo cl::$dataExpedicao ?>' required='required' type='date' id='data_de_expedicao' name=clientes[dataExpedicao] class='form-control'></p>
                    <hr><!------->    
                </div>
                <div class="col-lg-3">
                    <p><label>Documento!! </label>
                        <select style="width: 75%; float: right;"  v-change="salvaDadosCliente()"  v-model="documento" name=clientes[documento] class="form-control">
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
                    <p><label>endereço</label><input style="width: 80%; float: right;"  v-change="salvaDadosCliente()"  v-model="endereco" type='text' id='endereco' name=dados[endereco] class='form-control'></p>
                    <!------->
                </div>
                <div class="col-lg-3">
                    indicado por <input type="text" v-model="indicacao" @keyup="indicacaoFcn()" class="form-control">
                    <ul>
                        <li v-for="item in pessoaQueIndicou">{{item.nome}}\{{item.cpf}} <br> <input  v-change="salvaDadosCliente()"  type="hidden"  :value="item.id"  name=clientes[indicado] ></li>
                    </ul>
                    <!---name=dados['indicacao']['quemIndica']---->
                    <label>membro da equipe que atendeu este cliente:</label><input type="text"  v-change="salvaDadosCliente()" class="form-control" >


                </div>
            </div>
        </div>
        <!--------------------------------------------------------------------------->

        <div v-if="quadroContato" class="container dados_contato ">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Dados de contato</h2>
                    <span >    
                        <!------->
                        <p>
                            <span class="dashicons dashicons-phone"></span><b>Cadastro e lista de telefones</b>
                        </p>
                        <!------->
                        <p>
                            <label>Telefone</label><input style="width: 90%; float: right;"  type='text' v-model="telefone" v-on:change="CriaTel()" id='email' class='form-control' name=dados[telefone][telefone][] >
                        </p>
                        <!------->
                        <div v-for="item in telefones">
                            <div style="height: auto;overflow: auto; margin-bottom: 2px;">
                                <span class="icone-trash dashicons dashicons-trash" v-on:click="deletaTel(item,$event.target.value)"></span>
                                <!--<input style=" margin: 7px 1px 1px 15px;float: left;" checked="checked" type="checkbox"  :value="item.id"  v-on:click="deletaTel(item,$event.target.value)" >-->
                                <input style="width: 95%; float: right;"  v-on:change="editaTel(item,$event.target.value)" class="form-control" type="text" :value="item.telefone"  name=dados[telefone][telefone][] >
                            </div>
                        </div>
                        <hr>
                        <!------->

                        <p>
                            <span class="dashicons dashicons-email"></span><b>Cadastro e lista de emails</b>
                        </p>

                        <p>
                            <label>Novo e-mail</label>
                            <input style="width: 90%; float: right;" v-model="email" v-on:change="criarEmail()" type='email' id='email' name=dados[email][email][] class='form-control'>
                        </p>

                        <div v-for="item in emails">
                            <div style="height: auto;overflow: auto; margin-bottom: 2px;">
                                <span class="icone-trash dashicons dashicons-trash" @click="deletaEmail(item)"></span>
                                <!--<input style=" margin: 7px 1px 1px 15px;float: left;" checked="checked" type="checkbox"  :value="item.id" @click="deletaEmail(item)" >-->
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
            <div class="row"><div class="col-lg-12"><span class="dashicons dashicons-products"></span><h2> produtos </h2></div></div>
            <div class="row"  >

                <div class="col-md-3">
                    <h2>cadastrar novo produto para esse cliente:</h2>
                    <p><label>produto</label>


                        <select class="form-control" v-model="produto" type="text" name=dados[MeusProdutos][0][produto]>
                            <option v-for="item in listaProdutos" :value="item.id" >{{item.produto}}</option>
                        </select>
                    </p>
                    <p><label>valor</label><input v-model="valor" class="form-control" type="text" name=dados[MeusProdutos][0][valor]></p>
                    <p><label>comissão</label><input v-model="comissao" class="form-control" type="text" name=dados[MeusProdutos][0][comissao]></p>
                </div>
                <div class="col-md-2">
                    <h2>Cliente ativo?</h2>
                    <p>
                        <label>não ativo</label><input v-model="ativo"  type="radio" value="0"  name=dados[MeusProdutos][0][ativo]>
                        <label>ativo</label><input  v-model="ativo"  type="radio" value="1" name=dados[MeusProdutos][0][ativo]>
                    </p>
                    <p>
                        <span class="button" v-on:click="AssociaProduto()">cadastrar novo produto</span>
                    </p>
                </div>

                <div class="col-md-7">
                    <h3>produtos </h3>
                    <table>
                        <thead>
                            <tr>
                                <td>deletar</td>
                                <td>ativo</td>
                                <td>produto</td>
                                <td>valor</td>
                                <td>comissão</td>
                                <td>total</td>
                                <td>data</td>
                            </tr>
                        </thead>
                        <tr v-for="item in produtosDoClientes">
                            <td>
                                <div v-on:click="DesassociaProduto(item)">
                                    <span class="dashicons dashicons-trash"></span>
                                </div>
                            </td>
                            <td>{{item.ativo}}</td>
                            <td>{{item.produto}}</td>
                            <td>R${{item.valor}}</td>
                            <td>{{item.comissao}}</td>
                            <td>R${{item.total}}</td>
                            <td>{{item.data}}</td>
                        </tr>
                    </table>

                </div> 
                <hr>
            </div>
        </div>
        <!--------------------------------------------------------------------------->



        <!--------------------------------------------------------------------------->
        <div class="container quadroComentarios ">
            <div class="row" id="comentario">
                <div class="col-lg-12 comentario">

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
       background-color: rgba(0, 0, 0, 0);
       height: 100%;
       padding-top: 15%;
       margin-left: -35px;">
        <span> <img style="
                    position: absolute;
                    border: 0px solid;
                    display: inline-block;
                    margin: 0px;
                    right: 12%;
                    bottom: 0px;
                    width: 75px;
                    " 
                    src=" <?php echo plugin_dir_url('clientes') . "clientes/include/arquivos/imagens/load.gif" ?>"></span>
    </p>  
</div>   
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>
<script src="<?php echo Vue ?>"></script>
<script >

new Vue({
    el: "#app",
    data: {
        id: "",
        nome: "",
        tipo_de_pessoa: "",
        sexo: "",
        dataNascimento: "",
        dataExpedicao: "",
        documento: "",
        indicacao: "",
        id_cliente: "",
        cpf: "",
        rg: "",
        documento: "",
        endereco: "",
        pessoaQueIndicou: "",
        telefone: "",
        caixaComentario: "",
        comentarios: ["a informacao", "chuva"],
        emails: [],
        telefones: [],
        refEmail: "",
        email: "",
        processando: false,
        stand: true,
        referencia: "",
        quadroContato: true,
        produtosDoClientes: [],
        comissao: "",
        valor: "",
        produto: "",
        ativo: 1,
        listaProdutos: [],
        pesquisaDeCliente: "",
        listaClientesPesquisados: "",
        listaClientesPesquisadosDisplay: false,
    },
    watch: {
        id_cliente: function () {
            var App;
            App = this;
            /*********************************************************************************/
            /*************************pegando a lista de produtos*****************************/
            var ListaProdutos = {
                "comando": "listaDeProdutos",
            };
            var DadosListaDeProdutos = btoa(JSON.stringify(ListaProdutos));
            var Urlproduto = "http://localhost/corretorawp/wp-content/plugins/clientes/api/produtosAdm.php?dados=" + DadosListaDeProdutos + "";
            axios.get(Urlproduto).then(function (response) {
                App.listaProdutos = response.data;
                console.log("listagem de produtos -- " + Urlproduto);
            });
            /*********************************************************************/
            /*********************************************************************/
            var ProItem = {
                "cliente": App.id_cliente,
                "comando": "listar",
            };
            var dadosPro = btoa(JSON.stringify(ProItem));
            var urlPro = "http://localhost/corretorawp/wp-content/plugins/clientes/api/produtosAdm.php?dados=" + dadosPro + "";
            axios.get(urlPro).then(function (response) {
                console.log(" =>minha url : " + urlPro + " <= ");
                App.produtosDoClientes = response.data;
            });
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
                "cliente": App.id_cliente,
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
                /************************************************/
                /************************************************/
            })
        }
    },
    methods: {
        mostraLista: function () {
            var App = this;
            App.listaClientesPesquisadosDisplay = true;
        },

        chamaCliente: function (item) {
            var App;
            App = this;
            App.nome = item.nome;
            App.tipo_de_pessoa = item.tipo_de_pessoa;
            App.sexo = item.sexo;
            App.dataNascimento = item.dataNascimento;
            App.dataExpedicao = item.dataExpedicao;
            App.documento = item.documento;
            App.id_cliente = item.id;
            App.indicacao = item.indicado;
            App.cpf = item.cpf;
            App.rg = item.rg;
            App.documento = item.documento;
            App.endereco = item.endereco;
            App.listaClientesPesquisadosDisplay = false;
        },

        PesquisaCliente: function () {
            var App;
            App = this;
            App.processando = true;
            var itemCliente = {
                "cliente": App.pesquisaDeCliente,
                "comando": "pesquisa",
            };
            var DadosClientesPesquisa = btoa(JSON.stringify(itemCliente));
            var UrlClientes = "http://localhost/corretorawp/wp-content/plugins/clientes/api/clientesAdm.php?dados=" + DadosClientesPesquisa + "";
            axios.get(UrlClientes).then(function (response) {
                console.log(UrlClientes);
                App.listaClientesPesquisados = response.data;
                App.processando = false;
            });
        },
        AssociaProduto: function () {
            var App;
            App = this;
            App.processando = true;
            var ItemProdutos = {
                "cliente": App.id_cliente,
                "produto": App.produto,
                "comissao": App.comissao,
                "valor": App.valor,
                "ativo": App.ativo,
                "comando": "associa",
            }
            var DadosProduto1 = btoa(JSON.stringify(ItemProdutos));
            var Urlproduto = "http://localhost/corretorawp/wp-content/plugins/clientes/api/produtosAdm.php?dados=" + DadosProduto1 + "";
            axios.get(Urlproduto).then(function (response) {
                console.log("produto " + App.produto + " \r \n");
                console.log(Urlproduto);
                App.produtosDoClientes = response.data;
                App.produto = "";
                App.valor = "";
                App.comissao = "";
                App.processando = false;
            });
        },
        /***********************************************************/
        DesassociaProduto: function (item) {
            var App = this;
            App.processando = true;
            var ItemProdDelet = {
                "produto": item.id,
                "cliente": App.id_cliente,
                "data": item.data,
                "comando": "deletar"
            }
            var DadosProduto1 = btoa(JSON.stringify(ItemProdDelet));
            axios.get('http://localhost/corretorawp/wp-content/plugins/clientes/api/produtosAdm.php?dados=' + DadosProduto1 + '').then(
                    function (response) {
                        App.produtosDoClientes = response.data;
                        App.processando = false;
                        console.log('/r /n http://localhost/corretorawp/wp-content/plugins/clientes/api/produtosAdm.php?dados=' + DadosProduto1 + '');
                    }
            );
        },
        /***********************************************************/
        criarEmail: function () {
            var Url;
            var App;
            var ItemSv;
            App = this;
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
            ///App.emails = '';
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
            App.processando = true;
            //App.telefones = [];
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
                App.processando = false;
            },
                    );
        },
        /***********************************************/
        CriaTel: function () {
            var App;
            App = this;
            App.processando = true;
            ///App.telefones = "";
            var itemNtel = {
                "comando": "salva",
                "telefone": App.telefone,
                "cliente": App.id_cliente,
            }
            var dadosNtel = btoa(JSON.stringify(itemNtel));
            var Url = "http://localhost/corretorawp/wp-content/plugins/clientes/api/telAdm.php?dados=" + dadosNtel + "";
            axios.get(Url).then(function (response) {
                console.log(Url);
                App.telefones = response.data
                App.processando = false;
                App.telefone = "";
            });
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
        },
        salvaDadosCliente: function (item) {
            var App;
            App = this;
            
            ///App.processando = true;
            
            var itemCliente = {
                "id_cliente" : App.id_cliente,
                "comando":"salva",
                "nome": App.nome,
                "tipoPessoa": App.tipo_de_pessoa,
                "sexo": App.sexo,
                "dataDeNascimento": App.dataNascimento,
                "cpf":App.cpf,
                "rg":App.rg,
                "dataDeExpedicao":App.dataExpedicao,
                "documento":App.documento,
                "indicadoPor":App.pessoaQueIndicou,
            };
            var dadosCliente = btoa(JSON.stringify(itemCliente));
            var url = "http://localhost/corretorawp/wp-content/plugins/clientes/api/clientesAdm.php?dados="+dadosCliente+"";
            console.log("alterando dados do cliente \r \n "+url);
            axios.get(url).then(function(response){});
            
           ///App.processando = false;
           
        },
    },
    created: function () {
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
    .dashicons{
        font-size: 37px;
        height: 37px;
        border: 0px solid;
        width: auto;
        color:<?php echo $cor1; ?>;
    }
    h2{
        font-weight: bold;
        color:<?php echo $cor1; ?>!important;
    }
    body{
        color:<?php echo $cor1; ?>!important;
    }

    input, select,textArea, radio{color:<?php echo $cor2; ?>!important;}

    .button{
        border:none!important;;    
        padding: 11px 9px 34px 10px!important;;
        border-radius: 4px!important;
        display: inline-block!important;;
        text-transform: capitalize!important;
        color:<?php echo $cor0; ?>!important; 
        background-color: <?php echo $cor2; ?>!important;
    }
    .button:hover{
        color:<?php echo $cor0; ?>!important; 
        background-color: <?php echo $cor3; ?>!important; 
    }
</style>
