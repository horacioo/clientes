<?php

namespace Planet1;

class EstadoCivil
    {

    static $estado_civil;
    static $Lista_Estado_Civil;

    public static function Lista_Estado_Civil() {
        global $wpdb;
        self::$Lista_Estado_Civil = $wpdb->get_results("select * from Estado_civil",ARRAY_A);
    }










    }
