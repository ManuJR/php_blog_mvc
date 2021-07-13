<?php

    class Article extends DBConnection {
        private $id;
        private $title;
        private $text;
        private $user_id;
        private $created_at;
       
        public function __construct( $params ){
            foreach ($params as $key => $value) {
                $this->$key = $value;
            }
        }

        public function __get($name){
            return $this->$name;
        }


        /**
         *  Creación de artículo. Si no hay session activa no creamos artículo
         *  @param array $params campos del artículo
         *  @param Session $session session activa del usuario
         * 
         **/ 
        
        public static function create( $params, Session $session ){
            // si nohay session, lanzamos excepción de error
            if( !$session->isLogged() ){
                throw new Exception("No hay ningún usuario logueado");
            }

            $db = DBConnection::connect();

            $title      = $params['title'];
            $text       = $params['text'];

            // Hay que coger el user_id de la SESSION ACTIVA.
            $user_id    = $session -> getUserId();

            // Query de guardado en BBDD
            $q_insert = "INSERT INTO `article`(`title`, `text`, `user_id`) VALUES ('$title', '$text', '$user_id')";

            // Ejecutar query
            $exec_q_insert = $db -> query($q_insert);

            if( !$exec_q_insert ){
                throw new Exception("Fallo al guardar artículo");
            }
            // obtenemos el id generado por la última consulta mysqli
           
            $newpost_params = [ 
                'id'    =>  $db -> insert_id,
                'title' =>  $title,
                'text'  =>  $text 
            ];
           return new Article( $newpost_params );

        }
    }
    

?>