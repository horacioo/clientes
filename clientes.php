<?php

/*
  Plugin Name: Plugin para administração de clientes!!
  Description: módulo para administração de clientes.
  Author: Horácio
  Version: 1
  Author URI: http://planet1.com.br
 */



$url_atual = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
define("urlAdmin", $url_atual);
define('clienteSemEmail', "15 dias");
define("apiLista", plugin_dir_url('cliente.php') . "clientes/api/api_lista.php");
define("keyGoogleApi", "AIzaSyCJZaknPwDWQ4HplUGPvTwpaLtMEASvbgI");
define("meuIp", md5($_SERVER["REMOTE_ADDR"]));

date_default_timezone_set('Brazil/East');
add_action('init', 'myStartSession', 1);

function myStartSession() {
    if (!session_id()) {
        session_start();
    }
}








function my_myme_types($mime_types){
    $mime_types['json'] = 'text/json'; //Adding svg extension
    return $mime_types;
}
add_filter('upload_mimes', 'my_myme_types', 1, 1);









define("data", date("Y-m-d H:i:s"));

require_once 'config.php';

require_once 'include/grupos.php';
require_once 'include/clientes.php';
require_once 'include/Emails.php';
require_once 'include/DataBase.php';
require_once 'include/menu.php';
require_once 'include/form.php';
require_once 'include/mecanicas.php';
require_once 'include/RecebeForm.php';
require_once 'CustomPosts/textosEmail.php';
require_once 'CustomPosts/metaBoxeTextosEmail.php';


add_action('admin_menu', 'MenuClientes');
add_shortcode("Recebe-Form", 'entradaForm');



register_activation_hook(__FILE__, CriaTabelas);

function CriaTabelas() {
    /*     * ******************************************************************* */
    global $wpdb;

    $sql = "CREATE TABLE if not exists  `estado_civil` ( `id` int(11) NOT NULL AUTO_INCREMENT, `estado_civil` varchar(200) NOT NULL, PRIMARY KEY (`id`) ) ENGINE=InnoDB DEFAULT CHARSET=latin1; ";
    $wpdb->query($sql);
    

    $sql = "CREATE TABLE if not exists  `documento` ( `id` int(11) NOT NULL AUTO_INCREMENT, `documento` varchar(100) NOT NULL, PRIMARY KEY (`id`) ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    $wpdb->query($sql);


    $sql = "CREATE TABLE  if not exists `clientes` ( `id` int(11) NOT NULL AUTO_INCREMENT, `nome` varchar(250) NOT NULL, `tipo_de_pessoa` varchar(1) NOT NULL DEFAULT 'f', `sexo` varchar(1) NOT NULL DEFAULT 'm', `cpf` varchar(20) NOT NULL, `rg` varchar(20) NOT NULL, `dataExpedicao` date NOT NULL DEFAULT '0000-00-00', `dataNascimento` date NOT NULL DEFAULT '0000-00-00', `endereco` varchar(250) NOT NULL, `ip` varchar(100) NOT NULL, `entrada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id`), UNIQUE KEY `cpfNome` (`cpf`,`nome`) USING BTREE ) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;";
    $wpdb->query($sql);


    $sql = "CREATE TABLE if not exists  `email` ( `id` int(11) NOT NULL AUTO_INCREMENT, `email` varchar(200) NOT NULL, PRIMARY KEY (`id`), UNIQUE KEY `email` (`email`) ) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=latin1; ";
    $wpdb->query($sql);


    $sql = "CREATE TABLE if not exists `telefone` ( `id` int(11) NOT NULL AUTO_INCREMENT, `ddd` varchar(4) NOT NULL, `telefone` varchar(25) NOT NULL, PRIMARY KEY (`id`), UNIQUE KEY `telefone` (`telefone`) ) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=latin1; ";
    $wpdb->query($sql);


    $sql = "CREATE TABLE if not exists `clientesemail` ( `id` int(11) NOT NULL AUTO_INCREMENT, `clientes` int(11) NOT NULL, `email` int(11) NOT NULL, PRIMARY KEY (`id`), UNIQUE KEY `emailCli` (`clientes`,`email`), KEY `cliente` (`clientes`), KEY `email` (`email`), CONSTRAINT `ce_cliente` FOREIGN KEY (`clientes`) REFERENCES `clientes` (`id`) ON DELETE CASCADE, CONSTRAINT `ce_email` FOREIGN KEY (`email`) REFERENCES `email` (`id`) ON DELETE CASCADE ) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;";
    $wpdb->query($sql);


    $sql = "CREATE TABLE if not exists `clientestelefone` ( `id` int(11) NOT NULL AUTO_INCREMENT, `clientes` int(11) NOT NULL, `telefone` int(11) NOT NULL, PRIMARY KEY (`id`), UNIQUE KEY `clientetelefone` (`clientes`,`telefone`), KEY `cliente` (`clientes`), KEY `telefone` (`telefone`), CONSTRAINT `ct_cliente` FOREIGN KEY (`clientes`) REFERENCES `clientes` (`id`) ON DELETE CASCADE, CONSTRAINT `ct_telefone` FOREIGN KEY (`telefone`) REFERENCES `telefone` (`id`) ON DELETE CASCADE ) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=latin1; ";
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

    $wpdb->query($sql);
    /*     * ******************************************************************* */
    $sql = "CREATE TABLE `grupos` ( `id` int(11) NOT NULL AUTO_INCREMENT, `nome` varchar(250) NOT NULL, `criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id`), UNIQUE KEY `grupo` (`nome`) ) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1; ";
    $wpdb->query($sql);
    /*     * tabela de configurações* */
    $sql = " CREATE TABLE  if not exists  `config` ( `id` int(11) NOT NULL AUTO_INCREMENT, `ip` varchar(100) NOT NULL, `clienteNaoRecebeEmailpor` int(11) NOT NULL, PRIMARY KEY (`id`) ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;";
    $wpdb->query($sql);
    /*     * ******************************************************************* */
    $sql = "TRUNCATE config";
    $wpdb->query($sql);
    /*     * *************************************************************************** */
    $sql = "INSERT INTO `config` (`id`, `ip`, `clienteNaoRecebeEmailpor`) VALUES (1, '" . md5($_SERVER["REMOTE_ADDR"]) . "', 10);";
    $wpdb->query($sql);
    /*     * *************************************************************************** */

    $sql = "CREATE TABLE `logemail` ( `id` int(11) NOT NULL AUTO_INCREMENT, `cliente` int(11) NOT NULL, `email` int(11) NOT NULL, `tipoEmail` int(11) NOT NULL, `texto` int(11) NOT NULL, `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id`), KEY `cliente` (`cliente`), KEY `email` (`email`), KEY `texto` (`texto`), CONSTRAINT `le_cliente` FOREIGN KEY (`cliente`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION, CONSTRAINT `le_email` FOREIGN KEY (`email`) REFERENCES `email` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;";
    $wpdb->query($sql);

    /*     * *********************************************************************************** */
    $sql = "CREATE TABLE if not exists `clientesgrupos` ( `id` int(11) NOT NULL AUTO_INCREMENT, `grupo` int(11) NOT NULL, `cliente` int(11) NOT NULL, PRIMARY KEY (`id`), UNIQUE KEY `clienteGRupo` (`grupo`,`cliente`), KEY `cliente` (`cliente`), KEY `grupo` (`grupo`), CONSTRAINT `cliente` FOREIGN KEY (`cliente`) REFERENCES `clientes` (`id`) ON DELETE CASCADE, CONSTRAINT `grupo` FOREIGN KEY (`grupo`) REFERENCES `grupos` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    $wpdb->query($sql);
}









