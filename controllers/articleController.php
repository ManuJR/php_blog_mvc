<?php
    /**
     *  CRUD del ARTICLE
     * 
     * CREATE -->   VISTA 
     *              ACCIÓN
     * UPDATE   --> VISTA
     *          --> ACCIÓN
     * READ     --> VISTA
     * DELETE   --> ACCIÓN
     * 
     */

    class ArticleController
    {
        
        public function __construct( )
        {   
            
        }

        public function create(){
            global $session;
           
            try {

                $article = Article::create( $session, $_POST);
                header("Location: /article/$article->id");
            } catch (\Throwable $th) {
                
                $error = $th->getMessage();
                require_once($_SERVER['DOCUMENT_ROOT']."/views/article/create.php");
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

        public function show( $id ){
            global $session;
            try {
                $article = Article::getById( $id );
                $author = $article -> author;

                // carga de vista de artículo
                require_once($_SERVER['DOCUMENT_ROOT']."/views/article/show.php");

            } catch (\Throwable $th) {
               echo $th->getMessage();
            }

        }

        public function edit_view( $id ){
            global $session;
            try {
                $article = Article::getById( $id );
                
                // carga de vista de artículo
                require_once($_SERVER['DOCUMENT_ROOT']."/views/article/edit.php");

            } catch (\Throwable $th) {
               echo $th->getMessage();
            }

        }

        public function update( $id ){
            global $session;
            try {
                
                $article = Article::getById( $id );
                $article -> update( $session, $_POST );
                header("Location:/article/edit/$id");
                return;

            } catch (\Throwable $th) {
               echo $th->getMessage();
            }

        }
    
    }
    


?>