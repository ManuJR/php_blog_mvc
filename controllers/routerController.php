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

        public function request( $method, $uri, $controller, $action ){
            $id = null;

            /* Dos tipos de url:
                1.  /article/create, /login, /signup ...
                2.  /article/3 , /article/edit/34  ...
            */

            // Sustituimos el caracter / por la / escapada: \/ , para generar la expresión regular de forma dinámica con cualquier uri.
            $regexp_uri = str_replace('/', '\/', $uri);

            // Utilizaremos :id para los parámetros /id en las uris. Por eso, sustituimos el string :id, si viene, por [0-9]+, para ponerlo en la exp. regular

            // Si estamos en una uri que acaba en :id y la url que nos llega acaba en número, estamos en una url con parámetro /id
        

            //if( preg_match("/:id$/", $uri) && preg_match("/[0-9]+$/", $this->uri) ){
                $regexp_uri = str_replace(':id', '[0-9]+', $regexp_uri);
                $base_url = preg_replace("/[0-9]+$/", "" ,$this->uri);
                $id = str_replace( $base_url, "",  $this->uri );
           // }


            // Todas las exp. regulares empiezan y acaban por lo mismo /^uri_que_viene$/
            $regExp = "/^".$regexp_uri."$/";

            $validate_uri = preg_match($regExp, $this->uri);
           
   
            if( $this->method == $method && $validate_uri){
               
                $controller = new $controller();
                $controller -> $action( $id );
            }
        }

        public function manageUris(){
           
            
            $this->request( "GET", "/", "WebController", "index");
            $this->request( "GET", "/login", "WebController", "login");
            $this->request( "GET", "/signup", "WebController", "signup");

            // POST    /signup        CREAR USARIO
            $this->request( "POST", "/signup", "UserController", "create");

            // POST    /login        Login USARIO
            $this->request( "POST", "/login", "UserController", "login");
            
            // POST    /logout        Logout USARIO
            $this->request( "POST", "/logout", "UserController", "logout");

            // Vista de creación de artículo
            $this->request( "GET", "/article/new", "ArticleController", "new");

            // Creación de artículo
            $this->request( "POST", "/article/create", "ArticleController", "create");

            

            // Visualización de artículo /article/{id}
            //$this->request( "POST", "/article/:id", "ArticleController", "show");


            // if( $this->method == "GET" && preg_match("/^\/article\/[0-9]+$/", $this->uri) ){
            //     $id = str_replace( "/article/", "",  $this->uri );
            //     $articleController = new ArticleController();
            //     $articleController -> show( $id );
            // }

            $this->request( "GET", "/article/:id", "ArticleController", "show");
        } 
    
    }
    



?>