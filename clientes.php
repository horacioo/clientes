<?php

/*
  Plugin Name: @Plugin para administração de clientes!!
  Description: módulo para administração de clientes.
  Author: Horácio
  Version: 1
  Author URI: http://planet1.com.br
 */

$url_atual = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
define("urlApi", plugin_dir_url("clientes/")."clientes/api/");
define("urlAdmin", $url_atual);
define('clienteSemEmail', "15 dias");
define("apiLista", plugin_dir_url('cliente.php') . "clientes/api/api_lista.php");
define("keyGoogleApi", "AIzaSyCJZaknPwDWQ4HplUGPvTwpaLtMEASvbgI");
define("meuIp", md5($_SERVER["REMOTE_ADDR"]));
define("Vue", plugin_dir_url('clientes/') . "clientes/js/vue.min.js");


date_default_timezone_set('Brazil/East');
add_action('init', 'myStartSession', 1);



function myStartSession() {
    if (!session_id()) {
        session_start();
    }
}



function my_myme_types($mime_types) {
    $mime_types['xml']  = 'text/xml'; //Adding svg extension
    $mime_types['json'] = 'text/json'; //Adding svg extension
    //$mime_types['json'] = 'text/json'; //Adding svg extension
    return $mime_types;
}



add_filter('upload_mimes', 'my_myme_types', 1, 1);
define("data", date("Y-m-d H:i:s"));
require_once 'config.php';
require_once 'include/grupos.php';
require_once 'include/clientes.php';
require_once 'include/indicacoes.php';
require_once 'include/produto.php';
require_once 'include/Emails.php';
require_once 'include/DataBase.php';
require_once 'include/menu.php';
require_once 'include/form.php';
require_once 'include/mecanicas.php';
require_once 'include/EstadoCivil.php';
require_once 'include/endereco.php';
require_once 'include/telefone.php';
require_once 'include/cidade.php';
require_once 'include/estado.php';
require_once 'include/documento.php';
require_once 'include/RecebeForm.php';
require_once 'CustomPosts/textosEmail.php';
require_once 'CustomPosts/metaBoxeTextosEmail.php';
require_once 'include/token.php';

use Planet1\token;

add_action('admin_menu', 'MenuClientes');
add_shortcode("Recebe-Form", 'entradaForm');
add_shortcode("token", function() {

    $token = token::Token();
    print_r($token);

    return $x;
});
register_activation_hook(__FILE__, CriaTabelas);



function CriaTabelas() {
    /*     * ******************************************************************* */
    global $wpdb;

    $sql = " CREATE TABLE  if not exists  `estado_civil` ( `id` int(11) NOT NULL AUTO_INCREMENT, `estado_civil` varchar(200) NOT NULL, PRIMARY KEY (`id`), UNIQUE KEY `estado_civil` (`estado_civil`) ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1; ";
    $wpdb->query($sql);


    $sql = "CREATE TABLE  if not exists `documento` ( `id` int(11) NOT NULL AUTO_INCREMENT, `documento` varchar(100) NOT NULL, PRIMARY KEY (`id`), UNIQUE KEY `documento` (`documento`) ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1; ";
    $wpdb->query($sql);


    $sql = "CREATE TABLE  if not exists  `estado` ( `id` int(11) NOT NULL AUTO_INCREMENT, `estado` varchar(200) NOT NULL, PRIMARY KEY (`id`), UNIQUE KEY `estado` (`estado`) ) ENGINE=InnoDB AUTO_INCREMENT=4273 DEFAULT CHARSET=latin1; ";
    $wpdb->query($sql);


    $sql = "CREATE TABLE  if not exists `cidade` ( `id` int(11) NOT NULL AUTO_INCREMENT, `cidade` varchar(200) NOT NULL, `estado` int(11) NOT NULL, PRIMARY KEY (`id`), UNIQUE KEY `cidadeEstado` (`cidade`,`estado`), KEY `estado` (`estado`), CONSTRAINT `estado` FOREIGN KEY (`estado`) REFERENCES `estado` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ) ENGINE=InnoDB AUTO_INCREMENT=6909 DEFAULT CHARSET=latin1; ";
    $wpdb->query($sql);


    $sql = " CREATE TABLE if not exists `clientes` ( `id` int(11) NOT NULL AUTO_INCREMENT, `nome` varchar(250) NOT NULL, `tipo_de_pessoa` varchar(1) NOT NULL DEFAULT 'f', `sexo` varchar(1) NOT NULL DEFAULT 'm', `cpf` varchar(20) NOT NULL, `rg` varchar(20) NOT NULL, `dataExpedicao` date NOT NULL DEFAULT '0000-00-00', `dataNascimento` date NOT NULL DEFAULT '0000-00-00', `ip` varchar(100) NOT NULL, `entrada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, `documento` int(11) NOT NULL, `estado_civil` int(11) NOT NULL, PRIMARY KEY (`id`), UNIQUE KEY `cpfNome` (`cpf`,`nome`) USING BTREE, KEY `documento` (`documento`), KEY `estado civil` (`estado_civil`), CONSTRAINT `Cliente_estado_civil` FOREIGN KEY (`estado_civil`) REFERENCES `estado_civil` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION, CONSTRAINT `Clientes_documentos` FOREIGN KEY (`documento`) REFERENCES `documento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION ) ENGINE=InnoDB AUTO_INCREMENT=6438 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;";
    $wpdb->query($sql);


    $sql = "CREATE TABLE if not exists `endereco` ( `id` int(11) NOT NULL AUTO_INCREMENT, `cliente` int(11) NOT NULL, `endereco` varchar(200) CHARACTER SET latin1 NOT NULL, `numero` int(11) NOT NULL, `complemento` varchar(200) CHARACTER SET latin1 NOT NULL, `cep` varchar(15) CHARACTER SET latin1 NOT NULL, `bairro` varchar(200) CHARACTER SET latin1 NOT NULL, `cidade` int(11) NOT NULL, `estado` int(11) NOT NULL, PRIMARY KEY (`id`), UNIQUE KEY `endereco_cliente` (`cliente`,`endereco`,`numero`,`complemento`), KEY `cliente` (`cliente`), KEY `cidade` (`id`), KEY `estado` (`estado`), KEY `endereco_cidade` (`cidade`), CONSTRAINT `endereco_cidade` FOREIGN KEY (`cidade`) REFERENCES `cidade` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION, CONSTRAINT `endereco_cliente` FOREIGN KEY (`cliente`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION, CONSTRAINT `endereco_estado` FOREIGN KEY (`estado`) REFERENCES `estado` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ) ENGINE=InnoDB AUTO_INCREMENT=7773 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ROW_FORMAT=COMPACT;";
    $wpdb->query($sql);


    $sql = "CREATE TABLE if not exists `produtos` ( `id` int(11) NOT NULL AUTO_INCREMENT, `produto` varchar(200) CHARACTER SET latin1 NOT NULL, `apelido` varchar(200) CHARACTER SET latin1 NOT NULL, `descricao` text CHARACTER SET latin1 NOT NULL, PRIMARY KEY (`id`), UNIQUE KEY `produto_info` (`produto`), UNIQUE KEY `apelido` (`apelido`) ) ENGINE=InnoDB AUTO_INCREMENT=3129 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ROW_FORMAT=COMPACT;";
    $wpdb->query($sql);


    $sql = "CREATE TABLE  if not exists `clientesprodutos` ( `id` int(11) NOT NULL AUTO_INCREMENT, `clientes` int(11) NOT NULL, `produtos` int(11) NOT NULL, PRIMARY KEY (`id`), KEY `clienteProduto` (`clientes`,`produtos`), KEY `produto` (`produtos`), CONSTRAINT `produtos_cliente` FOREIGN KEY (`clientes`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION, CONSTRAINT `produtos_produtos` FOREIGN KEY (`produtos`) REFERENCES `produtos` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ) ENGINE=InnoDB AUTO_INCREMENT=14320 DEFAULT CHARSET=latin1;";
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

    /*     * *********************************************************************************** */
    $sql = "CREATE TABLE if not exists `dados_de_processos` (`id` int(11) NOT NULL,`dados` int(11) NOT NULL,`data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ) ENGINE=MEMORY DEFAULT CHARSET=latin1;";
    $wpdb->query($sql);

    /*     * *********************************************************************************** */

    $sql = "CREATE TABLE if not exists `token` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `token` varchar(200) NOT NULL,
                  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                  `ip` varchar(200) NOT NULL,
                  PRIMARY KEY (`id`),
                  UNIQUE KEY `ip` (`ip`,`token`) USING BTREE
                ) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=latin1;";
    $wpdb->query($sql);

    /*     * ******************************************************************************************************* */
    $sql = " CREATE TABLE  if not exists  `clientesprodutos` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `clientes` int(11) NOT NULL,
                  `produtos` int(11) NOT NULL,
                  `data` datetime NOT NULL,
                  `valor` float(10,2) NOT NULL,
                  `ativo` char(1) NOT NULL,
                  PRIMARY KEY (`id`),
                  KEY `clienteProduto` (`clientes`,`produtos`),
                  KEY `produto` (`produtos`),
                  KEY `cliente` (`id`),
                  CONSTRAINT `produtos_cliente` FOREIGN KEY (`clientes`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
                  CONSTRAINT `produtos_produtos` FOREIGN KEY (`produtos`) REFERENCES `produtos` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
                ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    $wpdb->query($sql);
    /*     * ******************************************************************************************************* */
    $sql="CREATE TABLE   if not exists  `indicacao` (
                  `id` int(11) NOT NULL,
                  `quemIndicou` int(11) NOT NULL,
                  `indicado` int(11) NOT NULL,
                  `data` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
                  UNIQUE KEY `cliente` (`quemIndicou`,`indicado`),
                  KEY `ref_cliente` (`indicado`),
                  KEY `quemIndica` (`quemIndicou`),
                  CONSTRAINT `cliente_que_inidicou` FOREIGN KEY (`quemIndicou`) REFERENCES `clientes` (`id`) ON DELETE CASCADE,
                  CONSTRAINT `cliente_ref` FOREIGN KEY (`indicado`) REFERENCES `clientes` (`id`) ON DELETE CASCADE
                ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    $wpdb->query($sql);
}


