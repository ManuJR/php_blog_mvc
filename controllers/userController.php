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

        public function profile()
        {
            global $session;
            // Si no hay session abierta, no dejamos pasar--> redirigimos a index

            $active_links = [
                "show"      => "active",
                "edit"      => "",
                "articles"  => ""
            ];
            if( !$session -> isLogged() ){
                header("Location: /");
            }
            $id = $session -> getUserId();
            $user = User::getById( $id );
          
            require_once($_SERVER['DOCUMENT_ROOT']."/views/user/profile.php");
        }

        public function edit_view()
        {
            global $session;
            $active_links = [
                "show"      => "",
                "edit"      => "active",
                "articles"  => ""
            ];
            if( !$session -> isLogged() ){
                header("Location: /");
            }
            $id = $session -> getUserId();
            $user = User::getById( $id );

            require_once($_SERVER['DOCUMENT_ROOT']."/views/user/edit.php");
        }

        public function update( $id ){
            global $session;
            try {
                $id = $session -> getUserId();
                $user = User::getById( $id );
                $user -> update( $session, $_POST );
                header("Location:/profile/");
                return;

            } catch (\Throwable $th) {
               echo $th->getMessage();
            }

        }

        public function change_email( ){
            global $session;
            try {
                $id = $session -> getUserId();
                $user = User::getById( $id );
                $user -> changeEmail( $session, $_POST );
                header("Location:/profile/");
                return;

            } catch (\Throwable $th) {
               echo $th->getMessage();
            }

        }

        public function change_password(){
            global $session;
            try {
                $id = $session -> getUserId();
                $user = User::getById( $id );
                $user -> changePassword( $session, $_POST );
                header("Location:/profile/");
                return;

            } catch (\Throwable $th) {
               echo $th->getMessage();
            }
        }
    }
    


?>