<?php

use FormulariosHTml\htmlRender as form;

function MenuClientes() {
    add_menu_page('cliente', 'clientes', 'administrator', 'clientes', clienteFunct, '', 1);
    add_submenu_page('clientes', 'novo_cliente', "novo cliente", 'administrator', 'novo_cliente', NovoclienteFunct);
    add_submenu_page('clientes', 'editar_cliente', "editar cliente", 'administrator', 'editar_cliente', Editar_cliente);
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
    echo form::Editar();
}




