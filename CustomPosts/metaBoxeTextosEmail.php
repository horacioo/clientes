<?php
add_action('add_meta_boxes', 'TextosEmail');

function TextosEmail() {
    add_meta_box(
            'link', //ID
            'Quando será enviado?', //Título
            'RedesSociais', //callback
            array('TextosEmail'), //Post Type
            'side', //Posição
            'high' //Prioridade
    );
}





function RedesSociais() {
    global $post;
    //$Rede = get_post_meta($post->ID, "Rede_Social")
    ?>
    <p><input type="radio" name="data" value='1'>aniversário</p>
    <p><input type="radio" name="data" value='2'>enviar este email a cada X dias</p>
    <p><input type="radio" name="data" value='3'>enviar no dia X</p>
    <p>repetir esse envio por X vezes</p>
    <p><input type="radio" name="data" value='4'>desativar este email</p>
              <!--<input type="text" style="width: 100%" value="<?php echo $Rede[0]; ?>" name="Rede_Social"> -->
    <?php
}




