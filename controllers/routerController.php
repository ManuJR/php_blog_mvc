<?php
    /**
     * Controlador que se encarga de manejar las rutas
     */
    class RouterController
    {
        private $method;
        private $uri;
       

        public function __construct(){
            $this->method   =   $_SERVER['REQUEST_METHOD'];
            $this->uri      =   $_SERVER['REQUEST_URI'];


             // Preguntar si hay session abierta! Si alguien ha hecho login previamente...
            //$this->checkSession();

        }

        public function manageUris(){
           
            
            if( $this->method == "GET" && $this->uri == "/" ){

                $webController = new WebController();
                $webController->index();
                
            }

            if( $this->method == "GET" && $this->uri == "/login" ){

                $webController = new WebController();
                $webController->login();
                
            }

            if( $this->method == "GET" && $this->uri == "/signup" ){
                
                $webController = new WebController();
                $webController->signup();
                
            }


            /*  
            Rutas de USUARIO:
                GET     /user/{id}          VIEW USER
                POST    /user/{id}          UPDATE
                GET     /user/edit/{id}     VIEW EDIT USER
                POST    /user/delete/{id}   BORRAR USUARIO
                POST    /user/signup        CREAR USARIO

            */
            // POST    /signup        CREAR USARIO
            if( $this->method == "POST" && $this->uri == "/signup" ){
                
                $userController = new UserController();
                $userController->create();
                
            }
            // POST    /login        Login USARIO
            if( $this->method == "POST" && $this->uri == "/login" ){
                
                $userController = new UserController();
                $userController->login();
                
            }

            // POST    /logout        Logout USARIO
            if( $this->method == "POST" && $this->uri == "/logout" ){
                
                $userController = new UserController();
                $userController->logout();
                
            }

            // Vista de creación de artículo
            if( $this->method == "GET" && $this->uri == "/article/new" ){
            
                $articleController = new ArticleController();
                $articleController -> new();
            }

            // Creación de artículo
            if( $this->method == "POST" && $this->uri == "/article/create" ){
            
                $articleController = new ArticleController();
                $articleController -> create();
            }
        } 
    
    }
    



?>