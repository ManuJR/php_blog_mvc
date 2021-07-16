<?php

    class Article extends DBConnection {
        const DEFAULT_IMG_HEADER = "/assets/imgs/blog_default.png";
        private $id;
        private $title;
        private $text;        
        private $user_id;
        private $author;
        private $img;
        private $short_text;
        private $created_at;
        private $session;

        public function __construct( $params ){
            global $session;
            $this->session = $session;
            
            foreach ($params as $key => $value) {
               
                if( $key == "img" && ( empty($value) || $value =="" ) ){
                    $this->img = Article::DEFAULT_IMG_HEADER;
                    continue;
                }
                $this->$key = $value;
            }

            $this -> short_text = $this -> generateShortText();
            $this -> saveAuthorData( $params );

        }

        public function __get($name){
            return $this->$name;
        }

        public function getImage(){
            if($this->img == Article::DEFAULT_IMG_HEADER){
                return $this->img;
            }
            $folder_img = "/uploads/posts/$this->id/";
            return $folder_img.$this->img;
        }
        
        private function generateShortText(){
            return substr($this->text, 0, 80);
        }

        /**
         *  Creación de artículo. Si no hay session activa no creamos artículo
         *  @param array $params campos del artículo
         *  @param Session $session session activa del usuario
         *  
         *  Primero valido campos de imagen, luego valido/guardo el artículo en BBDD y finalmente guardo la img
         **/ 
        
        public static function create( Session $session, $params ){
            // si nohay session, lanzamos excepción de error
            if( !$session->isLogged() ){
                throw new Exception("No hay ningún usuario logueado");
            }
            
            $title      = $params['title'];
            $text       = $params['text'];

            // Hay que coger el user_id de la SESSION ACTIVA.
            $user_id    = $session -> getUserId();
            
            // Comprobar imagen a subir 
            $img = Article::validationUploadedImg();
            
            $db = DBConnection::connect();
            // Query de guardado en BBDD
            $q_insert = "INSERT INTO `article`(`title`, `text`, `user_id`, `img`) VALUES ('$title', '$text', '$user_id', '$img')";

            // Ejecutar query
            $exec_q_insert = $db -> query($q_insert);

            if( !$exec_q_insert ){
                throw new Exception("Fallo al guardar artículo: ".$db->error);
            }
            // obtenemos el id generado por la última consulta mysqli
           
            $newpost_params = [ 
                'id'    =>  $db -> insert_id,
                'title' =>  $title,
                'text'  =>  $text ,
                'img'   =>  $img 
            ];

            $article = new Article( $newpost_params );
            
            // Guardado de imagen
            $article -> uploadImg( $_FILES['img_header'] );
            return $article;
        }

        public function update( Session $session, $params ){
            // si nohay session, lanzamos excepción de error
            if( !$session->isLogged() ){
                throw new Exception("No hay ningún usuario logueado");
            }
            $db = DBConnection::connect();

            $this -> title      = $params['title'];
            $this -> text       = $params['text'];

            // Comprobamos si la imagen es válida;
            $old_image = $this -> img;
            $this -> img = Article::validationUploadedImg();

            // Si lo es:
            // 1. Borramos imagen antigua
            $this -> deleteOldImg( $old_image );

            // 2. Subimos imagen nueva
            $this -> uploadImg( $_FILES['img_header'] );
            
            
            // Hay que coger el user_id de la SESSION ACTIVA.
            $user_id    = $session -> getUserId();
            if( !$this->isWritedByLoggedUser() ){
                throw new Exception("No tienes permiso para editar este artículo");
            }
            
            // Query de guardado en BBDD
            $q_update = "UPDATE `article` SET `title`='$this->title',`text`='$this->text', `img`='$this->img' WHERE `id`= '$this->id'";
            
            // Ejecutar query
            $exec_q_insert = $db -> query($q_update);

            if( !$exec_q_insert ){
                throw new Exception("Fallo al guardar artículo");
            }
            
           
           return $this;

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
        /**
         * Función que obtiene un artículo por id de la BBDD
         * Devuelve un Objeto Artículo
         * */ 
        public static function getById( $id ){
            // 1. conexión
            $db = DBConnection::connect();

            // 2. query de SELECT
            $query = "SELECT `article`.`*`, `user`.`name` AS 'autor_name', `user`.`surname` AS 'autor_surname', `user`.`email` AS 'autor_email' FROM `article`, `user` WHERE `article`.`id`='$id' AND `article`.`user_id` = `user`.`id`";
            
            // 3. ejecutar query
            $exec_query = $db -> query($query);
            
            if( !$exec_query){
                throw new Exception("Ha habido un error obteniendo el artículo");
            }
            if(  $exec_query->num_rows != 1 ){
                throw new Exception("No se encuentra el artículo");
            }
            
            // 4. Recoger datos
            $article_data = $exec_query->fetch_assoc();
    
            // 5. Convertir datos a objetos Article
            $article = new Article( $article_data );
            return $article;
        }

        private function saveAuthorData( $params ){
            
            if( !empty( $params['user_id'] ) && !empty( $params['autor_name'] ) ){
                $params_user = [
                     'id' => $params['user_id'],
                     'name' => $params['autor_name'],
                     'surname' => $params['autor_surname'],
                     'email' => $params['autor_email']
                ];
                $this -> author = new User( $params_user );
            }
        }

        public function isWritedByLoggedUser(){
            
            if( $this -> session -> isLogged() && $this -> session -> getId() == $this -> user_id){
                return true;
            }
            return false;
            
        }

        /**
         * Función encargada de validar y subir la imagen de cabecera
         * @return $name_img nombre de la imagen a guardar
         */
       
        private static function validationUploadedImg(){
            // 1. Validar campos de imagen $_FILES['img_header']
            if( !isset( $_FILES ) && empty( $_FILES ) ){
                return "";
            }

            if( !isset( $_FILES['img_header'] ) || empty( $_FILES['img_header'] ) ){
                return "";
            }
            
            // 2. Validar tipo de imagen: png, jpg, jpeg .gif ...
            $img    = $_FILES['img_header'];
            $type   = $img['type']; // image/gif, image/png, image/jpeg

            if( $type != 'image/gif' && $type != 'image/png' && $type != 'image/jpeg'){
                throw new Exception("La imagen subida no es un archivo válido");
            }
            return $img['name'] ;
        }

        /**
         * @param $img Imagen ($_FILES) a guardar
         * Guarda la imagen en la carpeta /post_id del articulo
         * Ya tenemos el objeto Article() creado, y la ventaja de crearlo como método (no estático) es que tenemos acceso a sus propiedades, entre ellas el id
         */
        private function uploadImg( $img ){
            $folder_article = "posts/$this->id";
            // Crear carpeta de uploads, para guardar imagenes 
            if( !file_exists( $_SERVER['DOCUMENT_ROOT']."/uploads" ) ){
                mkdir( $_SERVER['DOCUMENT_ROOT']."/uploads" );
            }
            if( !file_exists( $_SERVER['DOCUMENT_ROOT']."/uploads/posts" ) ){
                mkdir( $_SERVER['DOCUMENT_ROOT']."/uploads/posts" );
            }
            // Crear carpeta de /id, para guardar imagenes 
            if( !file_exists( $_SERVER['DOCUMENT_ROOT']."/uploads/$folder_article" ) ){
                mkdir( $_SERVER['DOCUMENT_ROOT']."/uploads/$folder_article" );
            }
            $final_target = $_SERVER['DOCUMENT_ROOT']."/uploads/$folder_article/$this->img";
            // Preguntamos si ya está guardada. Si es que si, no hacemos nada
            if( file_exists( $_SERVER['DOCUMENT_ROOT']."/uploads/$folder_article/$this->img" ) ){
                return;
            }

            if( !move_uploaded_file( $img['tmp_name'],  $final_target)){
                return false;
            }

            return true;
        }

        private function deleteOldImg( $img ){
            if( $img == Article::DEFAULT_IMG_HEADER || $img == "" ){
                return;
            }

            $old_image = $_SERVER['DOCUMENT_ROOT']."/uploads/posts/$this->id/$img";
            if( file_exists(  $old_image ) ){

                unlink("uploads/posts/$this->id/$img");
                return;
            }

        }
    }
    

?>