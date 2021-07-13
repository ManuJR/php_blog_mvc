<?php

    class Article extends DBConnection {
        private $id;
        private $title;
        private $text;
        private $user_id;
        private $img;
        private $short_text;
        private $created_at;
       
        public function __construct( $params ){
            foreach ($params as $key => $value) {
               
                if( $key == "img" && ( empty($value) || $value =="" ) ){
                    $this->img = "/assets/imgs/blog_default.png";
                    continue;
                }
                $this->$key = $value;
            }

            $this -> short_text = $this -> generateShortText();
         
        }

        public function __get($name){
            return $this->$name;
        }

        private function generateShortText(){
            return substr($this->text, 0, 80);
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

        public static function list( ){
            // 1. conexión
            $db = DBConnection::connect();

            // 2. query de SELECT
            $query = "SELECT * FROM `article` WHERE 1 ORDER BY `created_at` DESC";

            // 3. ejecutar query
            $exec_query = $db -> query($query);
            if( !$exec_query ){
                throw new Exception("Ha habido un error obteniendo los artículos");
            }

            // 4. Recoger datos
            $articles_data = $exec_query -> fetch_all( MYSQLI_ASSOC );

            // 5. Convertir datos a objetos Article
            $articles = [];
            foreach ($articles_data as $article) {
                $new_article = new Article($article);
                array_push($articles, $new_article);
            }

            return $articles;
        }
    }
    

?>