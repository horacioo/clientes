<?php

use Planet1\produto; ?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="container">
    <div class="row">
        <div class="col-md-7">
            <h2>Cadastro de produto</h2>
            <form action="" method="post" name="produtos">
                <p><label>produto</label><input class="form-control" type="text" name=produtos[produto]></p>
                <p><label>apelido</label><input class="form-control"  type="text" name=produtos[apelido]></p>
                <?php
                $content   = '';
                $editor_id = 'descricao';
                $settings  = array('textarea_name' => 'produtos[descricaoDoProduto]');
                wp_editor($content, $editor_id, $settings);
                ?>
                <input type="submit" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>
<?php
if ($_POST['produtos']):
    $dados              = $_POST['produtos'];
    produto::$produto   = $dados['produto'];
    produto::$apelido   = $dados['apelido'];
    produto::$descricao = $dados['descricaoDoProduto'];
    produto::create();
endif;
?>