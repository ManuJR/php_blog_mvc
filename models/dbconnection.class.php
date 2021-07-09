<?php
    class DBConnection {

        private const HOST       = "localhost";
        private const USER       = "root";
        private const PASSWORD   = "root";
        private const BBDD       = "trazos_blog";
        private $conection;

        public function __construct(){
            
            $conexion = mysqli_connect( self::HOST, self::USER, self::PASSWORD, self::BBDD ) or die("Hay problemas de conexión: ".mysqli_connect_error());
            
            $this->conection = $conexion;
            $this->conection->set_charset('utf8');

        }

        public function getConection(){
            return $this->conection;
        }

        public static function connect(){
            $conexion = mysqli_connect( self::HOST, self::USER, self::PASSWORD, self::BBDD ) or die("Hay problemas de conexión: ".mysqli_connect_error());

            return $conexion;
        }

        


    }
    



?>