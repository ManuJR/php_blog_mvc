<?php

    class UserController
    {
        
        public function __construct( )
        {   
            
        }

        public function create(){
            global $session;
            try {
           
                $user = User::signup($_POST);
                if($user){
                    header("Location: /login");
                }

            } catch (\Throwable $th) {
                echo "ERROR CREANDO USARIO<br>";
                $error = $th->getMessage();
                require_once($_SERVER['DOCUMENT_ROOT']."/views/user/signup.php");
            }
        }

        public function login(){
            global $session;
            try {

                $user = User::login( $_POST );
                header("Location: /");

            } catch (\Throwable $th) {
              
                $error = $th->getMessage();
                require_once($_SERVER['DOCUMENT_ROOT']."/views/user/login.php");
            }
        }

        public function logout(){
            global $session;
        
            $session -> destroy();
            header("Location: /");
        }
    }
    


?>