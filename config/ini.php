<?php
    // DEBUG ERRORS
    ini_set('display_errors', "1");
    error_reporting(E_ALL);
    
    

    // Archivo de Configuración y carga de ficheros
    spl_autoload_register( function($class_name){

        /* Carga de Modelos */
        // si existe la el archivo en /models , cargo el model
        if( is_file($_SERVER['DOCUMENT_ROOT']."/models/".$class_name.".class.php") ){
            require_once($_SERVER['DOCUMENT_ROOT']."/models/".$class_name.".class.php");
        }

        /* Carga de Controllers */
        // si existe el archivo en /controllers , cargo el controller
        if( is_file($_SERVER['DOCUMENT_ROOT']."/controllers/".$class_name.".php") ){
            require_once($_SERVER['DOCUMENT_ROOT']."/controllers/".$class_name.".php");
        }

    } );


?>