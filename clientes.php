<?php

/*
  Plugin Name: Plugin para administração de clientes!!
  Description: módulo para administração de clientes.
  Author: Horácio
  Version: 1
  Author URI: http://planet1.com.br
 */

define("apiLista", plugin_dir_url('cliente.php')."clientes/api/api_lista.php");
define("keyGoogleApi","AIzaSyCJZaknPwDWQ4HplUGPvTwpaLtMEASvbgI");


date_default_timezone_set('Brazil/East');
add_action('init', 'myStartSession', 1);
function myStartSession() {
    if (!session_id()) {
        session_start();
    }
}



define("data",date("Y-m-d H:i:s"));




require_once 'include/DataBase.php';

require_once 'include/menu.php';

require_once 'include/form.php';
require_once 'include/mecanicas.php';
require_once 'include/RecebeForm.php';

add_action('admin_menu', 'MenuClientes');
add_shortcode("Recebe-Form", 'entradaForm');



register_activation_hook(__FILE__, CriaTabelas);
function CriaTabelas() {
    /*     * ******************************************************************* */

    $sql = "CREATE TABLE if not exists  `clientes` ( `id` int(11) NOT NULL AUTO_INCREMENT, `nome` varchar(250) NOT NULL, `cpf` varchar(20) NOT NULL, `rg` varchar(20) NOT NULL, `dataExpedicao` date NOT NULL DEFAULT '0000-00-00', `dataNascimento` date NOT NULL DEFAULT '0000-00-00', `ip` varchar(100) NOT NULL, `entrada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id`), UNIQUE KEY `cpfNome` (`cpf`,`nome`) USING BTREE ) ENGINE=InnoDB AUTO_INCREMENT=288 DEFAULT CHARSET=latin1;";
    global $wpdb;
    $wpdb->query($sql);


    $sql = "CREATE TABLE if not exists  `email` ( `id` int(11) NOT NULL AUTO_INCREMENT, `email` varchar(200) NOT NULL, PRIMARY KEY (`id`), UNIQUE KEY `email` (`email`) ) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=latin1; ";
    global $wpdb;
    $wpdb->query($sql);


    $sql = "CREATE TABLE if not exists `telefone` ( `id` int(11) NOT NULL AUTO_INCREMENT, `ddd` varchar(4) NOT NULL, `telefone` varchar(25) NOT NULL, PRIMARY KEY (`id`), UNIQUE KEY `telefone` (`telefone`) ) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=latin1; ";
    global $wpdb;
    $wpdb->query($sql);


    $sql = "CREATE TABLE if not exists `clientesemail` ( `id` int(11) NOT NULL AUTO_INCREMENT, `clientes` int(11) NOT NULL, `email` int(11) NOT NULL, PRIMARY KEY (`id`), UNIQUE KEY `emailCli` (`clientes`,`email`), KEY `cliente` (`clientes`), KEY `email` (`email`), CONSTRAINT `ce_cliente` FOREIGN KEY (`clientes`) REFERENCES `clientes` (`id`) ON DELETE CASCADE, CONSTRAINT `ce_email` FOREIGN KEY (`email`) REFERENCES `email` (`id`) ON DELETE CASCADE ) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;";
    global $wpdb;
    $wpdb->query($sql);


    $sql = "CREATE TABLE if not exists `clientestelefone` ( `id` int(11) NOT NULL AUTO_INCREMENT, `clientes` int(11) NOT NULL, `telefone` int(11) NOT NULL, PRIMARY KEY (`id`), UNIQUE KEY `clientetelefone` (`clientes`,`telefone`), KEY `cliente` (`clientes`), KEY `telefone` (`telefone`), CONSTRAINT `ct_cliente` FOREIGN KEY (`clientes`) REFERENCES `clientes` (`id`) ON DELETE CASCADE, CONSTRAINT `ct_telefone` FOREIGN KEY (`telefone`) REFERENCES `telefone` (`id`) ON DELETE CASCADE ) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=latin1; ";
    global $wpdb;
    $wpdb->query($sql);


    $sql = " CREATE TABLE  if not exists  `contato` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `cliente` int(11) NOT NULL,
                  `data` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
                  `primeiroContato` int(11) NOT NULL DEFAULT '0',
                  PRIMARY KEY (`id`),
                  UNIQUE KEY `clienteData` (`cliente`,`data`),
                  KEY `cliente` (`id`),
                  KEY `con_cliente` (`cliente`),
                  CONSTRAINT `con_cliente` FOREIGN KEY (`cliente`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
                ) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;";
    global $wpdb;
    $wpdb->query($sql);
    /*     * ******************************************************************* */
}




