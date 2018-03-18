<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Planet1;

class token
    {

    static $ip;
    static $token;



    private static function CriaToken() {
        global $wpdb;
        $ip       = md5($_SERVER['REMOTE_ADDR']);
        self::$ip = $ip;
        $past     = date("Y-m-d H:i:s", strtotime("-35 minutes"));
        $data     = time();
        $token    = substr(md5($ip . $data), 0, 20); //substr(md5($_SERVER['REMOTE_ADDR']), 4, 11);
        $del      = "delete from token where data < '$past'";
        $ins      = "insert into token(token,ip)values('$token','$ip')";
        $wpdb->query($del);
        $wpdb->query($ins);
    }



    static function Token() {
        global $wpdb;
        self::CriaToken();
        $sel   = "select * from token where ip = '" . self::$ip . "' limit 1";
        $dados = $wpdb->get_row($sel, ARRAY_A);
        return $dados;
    }



    static function VerificaToken() {
        self::$token = $_POST['token'];
        global $wpdb;
        $sel         = "select * from token where token ='" . self::$token . "'";
        $dados       = $wpdb->get_row($sel, ARRAY_A);
        return $dados;
    }



    }
