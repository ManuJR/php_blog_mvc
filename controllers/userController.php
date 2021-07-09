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
                print_r($th->getMessage());
                $error = $th->getMessage();
                require_once($_SERVER['DOCUMENT_ROOT']."/views/user/signup.php");
            }
        }

        public function login(){
            global $session;
            try {

                $user = User::login( $_POST );

                echo "LOGIN CON ÉXITO";
                echo "<br>";
                print_r($user);
                echo "<br>";
                print_r($_SESSION);
            } catch (\Throwable $th) {
              
                $error = $th->getMessage();
                require_once($_SERVER['DOCUMENT_ROOT']."/views/user/login.php");
            }
        }


    }
    


?>