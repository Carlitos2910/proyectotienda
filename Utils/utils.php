<?php

    namespace Utils;

    class Utils{

        public static function deleteSession($name){
            if(!isset($_SESSION['name'])){
                $_SESSION['name'] = null;
                unset($_SESSION[$name]);
            }

            return $name;
        }

        public static function isAdmin(){
            if(!isset($_SESSION['admin'])){
                header("Location:".$_ENV['BASE_URL']);
            }else{
                return true;
            }
        }

        public static function isIdentity(){
            if(!isset($_SESSION['identity'])){
                header("Location:".$_ENV['BASE_URL']);
            }else{
                return true;
            }
        }

        public static function totalprice(){
            $total = 0;
            if (isset($_SESSION['carrito'])){
                foreach($_SESSION['carrito'] as $indice){
                    $total += ($indice['precio']*$indice['unidades']);
                }
            }
            return $total;
        }
    }

?>