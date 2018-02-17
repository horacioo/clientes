<?php

         use Planet1\clientes as cli;
         use Planet1\DataBase as db;
         use Planet1\EstadoCivil as ec;
         use Planet1\Emails as em;
         use Planet1\endereco as end;
         use Planet1\telefone as tel;
         use Planet1\grupos as gru;

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

         new em();
         new tel();

         cli::DadosCliente();
?>
<!--<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.5/angular.min.js'></script>-->





<br><br>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4">
            <h2>Editar dados do cliente</h2>
            <?php echo cli::Formulario(cli::$clienteArray) ?>
        </div>
        <div class="col-lg-4">
            <h2>Editar e-mails do cliente</h2>
            <!---------------------------------------------------------------------->
            <?php
                     echo em::Formulario();
                     echo"<hr>";

                     $emails = em::EmailCliente(cli::$IdCliente);
                     foreach ($emails as $e):
                         ?>
                         <?php echo em::Formulario($e); ?>
                     <?php endforeach; ?>
            <!---------------------------------------------------------------------->
        </div>
        <div class="col-lg-4">
            <h2>Editar telefones do cliente</h2>

            <?php echo tel::Formulario(); ?>
            <?php
                     foreach (tel::Telefone_do_cliente() as $tel):
                         echo tel::Formulario($tel);
                     endforeach;
            ?>
        </div>

        <div class="col-lg-4">
            <h2>Editar endereços do cliente</h2>

            <?php echo end::Formulario(); ?>
            <?php/*
                     foreach (end::endereco_cliente($id) as $end):
                         echo end::Formulario($end);
                     endforeach;
            */?>
        </div>

    </div>
</div>