<?php

/*
  Plugin Name: Plugin para administração de clientes
  Description: módulo para administração de clientes.
  Author: Horácio
  Version: 1
  Author URI: http://planet1.com.br
 */



require_once 'include/menu.php';
require_once 'include/DataBase.php';
require_once 'include/form.php';
require_once 'include/mecanicas.php';

BootStrap();
Angular();


add_action('admin_menu', 'MenuClientes');