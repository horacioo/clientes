<?php

require_once '../../../../wp-config.php';
require_once '../include/clientes.php';
require_once '../include/Emails.php';

use emailsProcessosEDados\Emails as em;
use Clientes\clientes as cliente;

EnviaAniversario();

function EnviaAniversario() {
    em::EnvioAniversario();
    $t = em::$texto;
    if (is_array($t)):
        foreach ($t as $t):
            $clientes = cliente::Aniversario();
            if (is_array($clientes)):
                foreach ($clientes as $cl):
                    foreach (em::EmailCliente($cl['id']) as $e) {
                        salvaDados($cl['id'], $e['id'], $t['id'], '1');
                    }
                endforeach;
            endif;
        endforeach;
    endif;
}










function enviaEmail() {
    
}










function salvaDados($cliente = '', $email = '', $texto = '', $tipoEmail = '') {
    global $wpdb;
    $insert = "insert into `logemail`(cliente,email,texto,tipoEmail)values(" . $cliente . "," . $email . "," . $texto . "," . $tipoEmail . ")";
    $wpdb->query($insert);
}










//sleep(2);


/*
            $to      = "lanterna_@hotmail.com"; //"lanterna_@hotmail.com";
            $subject = "email das ".date("d/m/Y H:i:s");
            $content = "só testando o cron";
            $headers = array('Content-Type: text/html; charset=UTF-8');
            $status  = wp_mail($to, $subject, $content, $headers);
            */