<?php

use Planet1\htmlRender as form;

function MenuClientes() {
    MenuClienteLateral();
    functionGrupos();
}





function MenuClienteLateral() {
    add_menu_page('cliente', 'clientes', 'administrator', 'clientes', clienteFunct, 'dashicons-admin-users', 1);
    add_submenu_page('clientes', 'novo_cliente', "novo cliente", 'administrator', 'novo_cliente', NovoclienteFunct);
    add_submenu_page('clientes', 'editar_cliente', "editar cliente", 'administrator', 'editar_cliente', Editar_cliente);
    add_submenu_page('clientes', 'form', "instruções de formulário", 'administrator', 'form', Form);
}




function Form(){
    require 'arquivos/guiaForm.php';
}




function clienteFunct() {
    BootStrap();
    Angular();
}





function NovoclienteFunct() {
    BootStrap();
    require_once 'arquivos/novoCliente.php';
    //echo form::dadosClienteInterno();
}





function Editar_cliente() {
     BootStrap();
    require_once 'arquivos/listaClientes.php'; // echo form::Editar();
}




function functionGrupos() {
    add_menu_page("grupos", 'grupos', 'administrator', 'grupos', Grupofunct, 'dashicons-groups', '1');
    add_submenu_page("grupos", 'novo grupo', 'criar grupo', 'administrator', 'criarGrupo', NovoGrupoFctn);
}

function Grupofunct(){}
function NovoGrupoFctn(){    require_once 'arquivos/grupo.php';}
