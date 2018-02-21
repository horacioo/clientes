<?php

namespace Planet1;

class estado
    {



    static function ListaEstado() {
        global $wpdb;
        $query = "select * from estado";
        $x     = $wpdb->get_results($query, ARRAY_A);
        return $x;
    }



    }
