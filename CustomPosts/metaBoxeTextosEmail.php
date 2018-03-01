<?php
use Planet1\DataBase;
add_action('add_meta_boxes', 'TextosEmail');

function TextosEmail() {
    add_meta_box(
            'link', //ID
            'como será enviado?', //Título
            'ConfiguracoesEmailEnvioCliente', //callback
            array('TextosEmail'), //Post Type
            'side', //Posição
            'high' //Prioridade
    );
}





function ConfiguracoesEmailEnvioCliente() {
    global $post;
    //$Rede = get_post_meta($post->ID, "Rede_Social")
    ?>
    <style>
        .metaboxes p, .metaboxes li{
            padding: 9px;
            margin: 1px;
            padding: 4px;
            list-style: none;
            border-bottom: 1px solid #e0e0e0;

        }
        .NumeroMenu{width:48px; font-size: 11px;}
        .textoMenor{

            border: 1px solid #cecece;
            border-radius: 6px;
            background-color: #00bdff17;
        }
    </style>
    <?php
    $diasApos   = get_post_meta($post->ID, "diasApos");
    $DadosEmail = get_post_meta($post->ID, "opcaoDeEmail");
    $opcaoEmail = $DadosEmail[0];
    $DataEmail  = get_post_meta($post->ID, "opcaoDeEmailData");
    if (isset($DataEmail[0])) {
        $agendada = $DataEmail[0];
    } else {
        $agendada = time();
    }
    ?>
    <div class="metaboxes">
        <p><input type="radio" name=email[email_setting] value='1' <?php if ($opcaoEmail == "1") { ?>checked='checked'<?php } ?> >aniversário do cliente</p>
        <p><input type="radio" name=email[email_setting] value='2' <?php if ($opcaoEmail == "2") { ?>checked='checked'<?php } ?> >enviar este email quando o cliente se cadastrar</p>
        <p><input type="radio" name=email[email_setting] value='3' <?php if ($opcaoEmail == "3") { ?>checked='checked'<?php } ?> >enviar no dia <input type='date' value="<?php echo date("Y-m-d", $agendada); ?>" name=email[DataEnvio] style='width: 138px;' ></p>
        <p><input type="radio" name=email[email_setting] value='4' <?php if ($opcaoEmail == "4") { ?>checked='checked'<?php } ?> >desativar este email</p>




                                    <p><!--<input type="radio" name=email[email_setting] value='5'>--> enviar para o grupo:</p>
        <ul>
            <?php
            $dados = DataBase::ListaGeral(array("tabela" => "grupos"));
            foreach ($dados as $x):
                ?> 
                <li class="gruposCheck"><input type="checkbox" name=email[clientegrupos][] value="<?php echo $x['id'] ?>"> <?php echo $x['nome']; ?></li>
            <?php endforeach; ?>
        </ul>
        <p><input type="radio" name=email[email_setting] value='5' <?php if ($opcaoEmail == "5") { ?>checked='checked'<?php } ?> >enviar <input name=email[diasApos] value="<?php echo $diasApos[0]; ?>" type='number' max="365" style='width: 59px;' > dias após o cadastro</p>

    </div>
    <?php
}





add_action('save_post', 'salva_dados_email');

function salva_dados_email() {
    global $post;
    
    //print_r($_POST['email']);
    
    $dados = $_POST['email'];

    $grupos = serialize($dados['clientegrupos']);

    update_post_meta($post->ID, "grupo", $grupos);

    switch ($dados['email_setting']):
        case 1: Aniversario($dados);
            break;
        case 2: AoCadastrar($dados);
            break;
        case 3: Agendamento($dados);
            break;
        case 4:Desativar($dados);
            break;
        case 5:envioApos($dados);
            break;
    endswitch;
    
}





function Aniversario($x) {
    if (isset($x['email_setting'])):
        global $post;
        update_post_meta($post->ID, 'opcaoDeEmail', sanitize_text_field($x['email_setting']));
    endif;
}





function AoCadastrar($x) {
    if (isset($x['email_setting'])):
        global $post;
        update_post_meta($post->ID, 'opcaoDeEmail', sanitize_text_field($x['email_setting']));
    endif;
}





function Agendamento($x) {
    if (isset($x['email_setting'])):
        global $post;
        $data = strtotime($x['DataEnvio']);
        //print_r($x['DataEnvio']); //
        //exit();
        update_post_meta($post->ID, 'opcaoDeEmail', sanitize_text_field($x['email_setting']));
        update_post_meta($post->ID, 'opcaoDeEmailData', sanitize_text_field($data));
    endif;
}





function Desativar($x) {
    if (isset($x['email_setting'])):
        global $post;
        update_post_meta($post->ID, 'opcaoDeEmail', sanitize_text_field($x['email_setting']));
    endif;
}





function DiasApos($x) {
    if (isset($x['email_setting'])):
        print_r($x);
        global $post;
        update_post_meta($post->ID, "diasApos", $x['diasApos']);
        update_post_meta($post->ID, 'opcaoDeEmailDiasApos', sanitize_text_field($x['email_setting']));
        exit();
    endif;
}





function EnviarAgora($x) {
    if (isset($x['email_setting'])):
        global $post;
        update_post_meta($post->ID, 'opcaoDeEmail', sanitize_text_field($x['email_setting']));
    endif;
}




/****aqui eu vou enviar aos clientes que entraram no sistema após x dias**/
function envioApos($x) {
    if (isset($x['email_setting'])):
        global $post;
        update_post_meta($post->ID, 'diasApos' , sanitize_text_field($x['diasApos']) );
        update_post_meta($post->ID, 'opcaoDeEmail', sanitize_text_field($x['email_setting']));
    endif;
}




