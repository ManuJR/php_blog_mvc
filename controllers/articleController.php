<?php

    class ArticleController
    {
        
        public function __construct( )
        {   
            
        }

        public function create(){
            global $session;
           
            try {

                Article::create($_POST, $session);

            } catch (\Throwable $th) {
               echo $th->getMessage();
            }
        }

        public function new(){
            global $session;
            // Si no hay session redirijo a login
            if( !$session -> isLogged() ){
                header("Location: /login");
                return;
            }
            
            require_once($_SERVER['DOCUMENT_ROOT']."/views/article/create.php");
        }

    }
    


?>