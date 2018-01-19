<?php

//registrar_Grupos_de_Clientes();
add_action( 'init', 'registrar_Grupos_de_Clientes' );
function registrar_Grupos_de_Clientes() {
  $descritivos = array(
    'name' => 'Grupos para Envio de Email',
    'singular_name' => 'Grupos',
    'add_new' => 'Adicionar Novo grupo',
    'add_new_item' => 'Adicionar grupo',
    'edit_item' => 'Editar grupo',
    'new_item' => 'Novo grupo',
    'view_item' => 'Ver grupo',
    'search_items' => 'Procurar grupo',
    'not_found' =>  'Nenhum grupo encontrado',
    'not_found_in_trash' => 'Nenhum grupo na Lixeira',
    'parent_item_colon' => '',
    'menu_name' => 'Grupos de envio de email'
  );
  $args = array(
    'labels' => $descritivos,  //Insere o Array de labels dentro do argumento de labels
    'public' => true,  //Se o Custom Type pode ser adicionado aos menus e exibidos em buscas
    'hierarchical' => false,  //Se o Custom Post pode ser hierarquico como as páginas
    'menu_position' => 2,  //Posição do menu que será exibido
    'supports' => array('title','editor','thumbnail','excerpt') //'supports' => array('title','thumbnail','excerpt', 'revisions','editor','page-attributes') 
    );
  register_post_type( 'gruposDeClientes' ,$args );
  flush_rewrite_rules();
}
