<?php
    class DBConnection {

        private const HOST       = "localhost";
        private const USER       = "mjimenez_2021";
        private const PASSWORD   = 'WkT(Ev6,8-Vy';
        private const BBDD       = "mjimenez_trazos_blog_2021";

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