<?php

//registrar_TextosParaEmail();
add_action('init', 'registrar_TextosParaEmail');

function registrar_TextosParaEmail() {
    $descritivos = array(
        'name'               => 'Textos para serem enviador por email',
        'singular_name'      => 'Texto',
        'add_new'            => 'Adicionar Novo texto',
        'add_new_item'       => 'Adicionar texto',
        'edit_item'          => 'Editar texto',
        'new_item'           => 'Novo texto',
        'view_item'          => 'Ver texto',
        'search_items'       => 'Procurar texto',
        'not_found'          => 'Nenhum texto encontrado',
        'not_found_in_trash' => 'Nenhum texto na Lixeira',
        'parent_item_colon'  => '',
        'menu_name'          => 'textos para email'
    );
    $args        = array(
        'labels'        => $descritivos, //Insere o Array de labels dentro do argumento de labels
        'menu_icon'     => 'dashicons-media-document',
        'public'        => true, //Se o Custom Type pode ser adicionado aos menus e exibidos em buscas
        'hierarchical'  => false, //Se o Custom Post pode ser hierarquico como as páginas
        'menu_position' => 1, //Posição do menu que será exibido
        'supports'      => array('title', 'editor') //'supports' => array('title','thumbnail','excerpt', 'revisions','editor','page-attributes') 
    );
    register_post_type('TextosEmail', $args);
    flush_rewrite_rules();
}




