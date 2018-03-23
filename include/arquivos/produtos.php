<?php

use Planet1\produto; 
?>

<?php
/********************************/
if (isset($_POST['deleta'])) {
    print_r($_POST['deleta']);
    $endereco = urlApi . "produtos.php?dados=1&entrada=3&produto=" . $_POST['deleta']['id'];
    file($endereco);
}
/********************************/
if ($_POST['produtos']):
    $dados               = $_POST['produtos'];
    $id                  = $dados['id'];
    produto::$id_produto = $id;
    produto::$produto    = $dados['produto'];
    produto::$apelido    = $dados['apelido'];
    produto::$descricao  = $dados['descricaoDoProduto'];

    if (!is_null($id) AND is_numeric($id) AND $id > 0) {
        produto::Update();
    } else {
        produto::create();
    }
endif;
/********************************/
?>
<style>
    .cor_texto{
        font-size: 13px!important;
        display: block!important;
        text-align: justify!important;
        color: #8a8a8a!important;
    }
    .botao{    
        font-size: 10px;
        display: inline-block;
    }
    ul{}
    .listasLi{
        margin-bottom: 1px;
        list-style: none;
        background-color: #ffd9ff;
        color: #777777;
        padding: 13px;
        font-size: 13px!important;
    }
    .listasLi:hover{
        background-color: #efff91;
        color: #353535;
    }
</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="container" id="app">
    <form action="" method="post" name="produtos">
        <div class="row">
            <div class="col-md-7">
                <h2>{{ mensagem }}</h2>       
                <input v-model="id" class="form-control cor_texto" type="hidden" name=produtos[id]>
                <p><label>produto</label><input v-model="produto" class="form-control cor_texto" type="text" name=produtos[produto]></p>
                <p><label>apelido</label><input class="form-control cor_texto" v-model="apelido"  type="text" name=produtos[apelido]></p>
                <p><textarea v-model="descricao" name=produtos[descricaoDoProduto] class="form-control cor_texto" rows="10"></textarea></p>
                <!--<?php
                $content   = '';
                $editor_id = 'descricao';
                $settings  = array('textarea_name' => 'produtos[descricaoDoProduto]');
                wp_editor($content, $editor_id, $settings);
                ?>-->
                <input type="submit" class="btn btn-primary">

            </div>
            <div class="col-md-5">
                <h2>produtos existentes</h2>
                <?php foreach (produto::ListaProdutos() as $li): ?>
                    <li class='listasLi'>
                        <?php echo $li['produto']; ?>
                        <input type="radio" v-model="id" value="<?php echo $li['id']; ?>" v-on:click='produtoInfoAltera(<?php echo $li['id']; ?>)' >
                    <deleta-dados class="botao" valor="<?php echo $li['id']; ?>" >
                    </deleta-dados>
                    </li>
                <?php endforeach; ?>
            </div>
        </div>
    </form>

</div>



<script>var apiPasta = "<?php echo urlApi ?>"</script>

<script src="<?php echo Vue ?>"></script>




<script>
    Vue.component('deleta-dados', {
        template: `<div> 
                      <form action='' method='post' name='deleta'>
                          <input type="hidden" name=deleta[id] :value='valor'>
                              <slot></slot>
                                  <input type='submit' value='deletar'>
                      </form>
                  </div>`,
        props: ["valor", "etiqueta"],
    })
</script>






<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>
<script>
    var app = new Vue({
        el: "#app",
        data: {
            mensagem: "Cadastrar produto",
            produto: "",
            descricao: "",
            apelido: "",
            id: "",
            visivel: false
        },
        methods: {
            produtoInfoAltera: function (info) {
                var app = this;
                //produtos.php?dados=1&entrada=2&produto=5223
                app.mensagem = "Editar produto",
                        app.id = info;
                var url;
                url = apiPasta + "produtos.php?dados=1&entrada=2&produto=" + app.id;
                axios.get(url).then(function (response) {
                    app.mensagem = "Arguarde, carregando dados";
                    console.log(response.data);
                    app.produto = response.data.produto;
                    app.apelido = response.data.apelido;
                    app.descricao = response.data.descricao;
                    app.mensagem = "Editar produto";
                }
                );
            }
        }
    });

</script>