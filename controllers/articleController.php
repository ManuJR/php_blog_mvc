<?php

    class ArticleController
    {
        
        public function __construct( )
        {   
            
        }

        public function create(){
            global $session;
            echo "<br>";
            try {

                Article::create($_POST, $session);

            } catch (\Throwable $th) {
               echo $th->getMessage();
            }
        }

        public function new(){
            global $session;
            require_once($_SERVER['DOCUMENT_ROOT']."/views/article/create.php");
        }

    }
    


?>