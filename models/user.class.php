<?php

    class User extends DBConnection {
        const DEFAULT_IMG_PROFILE= "/assets/imgs/profile-user.svg";
        private $id;
        private $name;
        private $surname;
        private $img;
        private $email;
        private $password;
        private $created_at;
       
        public function __construct( $params ){
            foreach ($params as $key => $value) {
                $this->$key = $value;
            }
        }

        public function __get($name){
            return $this->$name;
        }

        public function getSrcImg(){
            if( !$this->img || empty($this->img) ){
                return self::DEFAULT_IMG_PROFILE;
            }
            return "/uploads/users/$this->id/$this->img";
        }

        public function getFullName(){
            return $this->name." ".$this->surname;
        }

        private static function cifratePassword($pass){
            return password_hash($pass, PASSWORD_DEFAULT);
        }
        
        private static function validateSignUpFields( $params ){
            
            self::emptySignupFields( $params );
            self::validateEmail( $params['email'] ); 
            self::validatePassword( $params['password'] );

            return true;
        }

        private static function validateLoginFields( $params ){

            self::emptyLoginFields( $params );
            self::validateEmail( $params['email'] ); 
            self::validatePassword( $params['password'] );

            return true;
        }

        public static function signup( $params ){
            // Validación de campos
            if(!self::validateSignUpFields( $params )){
                throw new Exception("Validación de campos de registro fallida");
                return;
            }
            // Creación de usuario
            return self::create( $params );
        }


        public static function create( $params ){
            $db = DBConnection::connect();

            $email      = $params['email'];
            $password   = self::cifratePassword( $params['password'] );
            $name       = $params['name'];
            $surname    = $params['surname'];

            // preguntar si existe en BBDD
            $query = "SELECT `id` FROM `user` WHERE `email` = '$email'";
            $exec_query = $db -> query($query);
          
            if(!$exec_query){
                throw new Exception("Error comprobando usuario: ". $db->error);
            }
            if($exec_query->num_rows>0){
                throw new Exception("Ya existe este usuario ");
            }
            
            // Registro
            $query = "INSERT INTO `user`(`name`, `email`, `password`, `surname` ) VALUES ('$name', '$email', '$password', '$surname')";

            $exec_query = $db -> query($query);
            if(!$exec_query){
                throw new Exception("Error registrando usuario: ". $db->error);
            }

            $params['password'] = $password;
            return new User($params);

        }


        public static function login( $params ){
            
            // Validando campos
            self::validateLoginFields( $params );

            $user = self::checkLoginDB( $params );
            global $session;
            $session->create( $user ); // name, surname, password, email...

            return $user;
        }

        public static function getById( $id ){
            // 1. conexión
            $db = DBConnection::connect();

            // 2. query de SELECT
            $query = "SELECT * FROM `user` WHERE `user`.`id`='$id'";
           
            // 3. ejecutar query
            $exec_query = $db -> query($query);
            
            if( !$exec_query){
                throw new Exception("Ha habido un error obteniendo el usuario");
            }
            if(  $exec_query->num_rows != 1 ){
                throw new Exception("No se encuentra el usuario");
            }
            
            // 4. Recoger datos
            $user_data = $exec_query->fetch_assoc();
    
            // 5. Convertir datos a objetos Article
            $user = new User( $user_data );
            return $user;
        }


        public function update( Session $session, $params ){
            
            if( !$session->isLogged() ){
                throw new Exception("No hay ningún usuario logueado");
            }
            $db = DBConnection::connect();
            self::emptyUpdateFields( $params );

            $this -> name           = $params['name'];
            $this -> surname        = $params['surname'];
  
            $old_image = $this -> img;
            $new_img = ManageFile::validationUploadedImg('profile_img');

            if( !empty($new_img) ){
                $this ->img = $new_img;

                $this -> deleteOldImg( $old_image );

                $this -> uploadImg( $_FILES['profile_img'] );
  
            }

            
            // Query de guardado en BBDD
            $q_update = "UPDATE `user` SET `name`='$this->name',`surname`='$this->surname', `img`='$this->img' WHERE `id`= '$this->id'";
            
            // Ejecutar query
            $exec_q_insert = $db -> query($q_update);

            if( !$exec_q_insert ){
                throw new Exception("Fallo al guardar usuario");
            }
            
           
           return $this;

        }


        public function changeEmail(  Session $session, $params ){
              
            if( !$session->isLogged() ){
                throw new Exception("No hay ningún usuario logueado");
            }

            if( !isset( $params['email'] ) || empty($params['email']) ){
                throw new Exception("Campo email no puede estar vacío");
            }
            
            self::validateEmail( $params['email'] ); 
            
            $db = DBConnection::connect();
            $this -> email           = $params['email'];

            
            // Query de guardado en BBDD
            $q_update = "UPDATE `user` SET `email`='$this->email' WHERE `id`= '$this->id'";
            
            // Ejecutar query
            $exec_q_insert = $db -> query($q_update);

            if( !$exec_q_insert ){
                throw new Exception("Fallo al cambiar el email");
            }

            $session -> setEmail($this -> email );
           
           return $this;
        }

        public function changePassword(Session $session, $params ){
              
            if( !$session->isLogged() ){
                throw new Exception("No hay ningún usuario logueado");
            }

            if( !isset( $params['password'] ) || empty($params['password']) ){
                throw new Exception("Campo password no puede estar vacío");
            }
            
            self::validatePassword( $params['password'] ); 
            
            $db = DBConnection::connect();
            $this -> password  =  self::cifratePassword( $params['password'] );

            
            // Query de guardado en BBDD
            $q_update = "UPDATE `user` SET `password`='$this->password' WHERE `id`= '$this->id'";
            
            // Ejecutar query
            $exec_q_insert = $db -> query($q_update);

            if( !$exec_q_insert ){
                throw new Exception("Fallo al cambiar la contraseña");
            }
           
           return $this;
        }

        private static function checkLoginDB( $params ){
  
            $db = DBConnection::connect();
            // Query de búsqueda de usuario por email
            $email      = $params['email'];
            $password   = $params['password'];
            $query = "SELECT * FROM `user` WHERE `email` = '$email'";

            // Ejecutar query
            $exec_query = $db -> query( $query );

            if( $exec_query -> num_rows != 1 ){

                throw new Exception("Este usuario no está registrado");
                return false;
            }

            // Recoger Usuario
            $user_login_db = $exec_query -> fetch_assoc();
            
            // comprobar contraseña
            if( !password_verify( $password  ,$user_login_db['password'] ) ){
                // Contraseña incorrecta;
                throw new Exception("La contraseña no es correcta");
                return false;
            }

            $user = new User( $user_login_db );

            return $user;
        }



        /*
            Campos obligatorios: email, password
        */
        private static function emptySignupFields( $params ){
            
            if( !$params || 
            ( ( !isset($params['password']) || empty($params['password']) ) && 
            ( !isset($params['email']) || empty($params['email']) ) ) &&
            ( !isset($params['name']) || empty($params['name']) )  
            ){
               
                throw new Exception("Los campos están vacíos");
                return false;
            }
            if ( !isset($params['name']) || empty($params['name'] ) ){
                throw new Exception("El campo name está vacío");
                return false;
            }

            if ( !isset($params['email']) || empty($params['email'] ) ){
                throw new Exception("El campo email está vacío");
                return false;
            }

            if ( !isset($params['password']) || empty($params['password'] ) ){
                throw new Exception("El campo password está vacío");
                return false;
            }
            return true;
           
        }

        private static function emptyUpdateFields( $params ){
            
            if( !$params ||
             ( !isset($params['name']) || empty($params['name']) )  
            ){
               
                throw new Exception("Los campos están vacíos");
                return false;
            }
            if ( !isset($params['name']) || empty($params['name'] ) ){
                throw new Exception("El campo name está vacío");
                return false;
            }

            return true;
           
        }

        private static function validateEmail( $email ){

            $email = filter_var($email, FILTER_VALIDATE_EMAIL);

            if(!$email){
                throw new Exception("Formato del correo inválido");
                return false;
            }
            return $email;
        }

        private static function validatePassword( $password ){
            if( strlen($password)<6 ){
                throw new Exception("La contraseña tiene que tener al menos 6 caracteres");
                
                return false;
            }

            if( stristr($password, "password") ){
                throw new Exception("La contraseña no puede contener la palabra password");

                return false;
            }

            return true;
        }

        private static function emptyLoginFields( $params ){
           
            if( !$params || 
            ( ( !isset($params['password']) || empty($params['password']) ) && 
            ( !isset($params['email']) || empty($params['email']) )  )  
            ){
               
                throw new Exception("Los campos están vacíos");
                return false;
            }

            if ( !isset($params['email']) || empty($params['email'] ) ){
                throw new Exception("El campo email está vacío");
                return false;
            }

            if ( !isset($params['password']) || empty($params['password'] ) ){
                throw new Exception("El campo password está vacío");
                return false;
            }
            return true;
           
        }

        private function deleteOldImg( $img ){
            if( $img == self::DEFAULT_IMG_PROFILE || $img == "" ){
                return;
            }
            $old_image = "/uploads/users/$this->id/$img";
            ManageFile::deleteFile( $old_image );
        }


        private function uploadImg( $img ){
            $folder_user = "users/$this->id";
            // Crear carpeta de uploads, para guardar imagenes 
            ManageFile::createFolder("/uploads");
            ManageFile::createFolder("/uploads/users");
            ManageFile::createFolder("/uploads/users/$this->id");

            $final_target = "/uploads/$folder_user/$this->img";
            // Preguntamos si ya está guardada. Si es que si, no hacemos nada
            if( ManageFile::exists( $final_target ) ){
                return;
            }

            return ManageFile::uploadFile($img['tmp_name'], $final_target);

        }

    }
    

?>