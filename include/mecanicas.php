<?php

function BootStrap(){
     wp_register_style('bootStrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css');
     wp_enqueue_style('bootStrap');
}


function Angular() {
    wp_register_script('Angular', 'https://cdnjs.cloudflare.com/ajax/libs/angular.js/2.0.0-alpha.34/angular2.dev.js');
    wp_enqueue_script('Angular');
}
