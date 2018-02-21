<?php

         namespace Planet1;

         /**
          * Description of cidade
          *
          * @author horacio
          */
         class cidade {
             static function ListaCidade(){
                 global $wpdb;
                 $query = "select * from cidade";
                 $x = $wpdb->get_results($query,ARRAY_A);
                 return $x;
             }
         }
         