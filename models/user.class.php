<?php

    class User extends DBConnection {
        private $id;
        private $name;
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

    }
    

?>