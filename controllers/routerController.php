<?php
    /**
     * Controlador que se encarga de manejar las rutas
     */
    class RouterController
    {
        private $method;
        private $uri;
       

        public function __construct(){
           
            $this->method       =   $_SERVER['REQUEST_METHOD'];
            $this->query_string =   $_SERVER['QUERY_STRING'];
            $this->uri          =   str_replace( "?".$this->query_string , "", $_SERVER['REQUEST_URI']);

        }


        /* Dos tipos de url:
            1.  /article/new, /login, /signup ...
            2.  /article/3 , /article/edit/34  ...
        */


        /**
         * @param $method_must Método que debe venir en la uri
         * @param $uri_must Uri que debe venir para enviar a controlador - acción
         * @param $controller Clase del controlador al que enviamos esa ruta 
         * @param $action Método del controlador que se ejecuta
         */
        public function request( $method_must, $uri_must, $controller, $action ){
            global $session;
            $id = null;
            
            // Sustituimos el caracter / por la / escapada: \/ , para generar la expresión regular de forma dinámica con cualquier uri.
            $regexp_uri = str_replace('/', '\/', $uri_must);

            // Utilizaremos :id para los parámetros /id en las uris. Por eso, sustituimos el string :id, si viene, por [0-9]+, para ponerlo en la exp. regular

            // Si estamos en una uri que acaba en :id y la url que nos llega acaba en número, estamos en una url con parámetro /id
        

            //if( preg_match("/:id$/", $uri) && preg_match("/[0-9]+$/", $this->uri) ){
                $regexp_uri = str_replace(':id', '[0-9]+', $regexp_uri);
                $base_url = preg_replace("/[0-9]+$/", "" ,$this->uri);
                $id = str_replace( $base_url, "",  $this->uri );

                //$id = str_replace( "page=", "",  $this->query_string );

           // }


            // Todas las exp. regulares empiezan y acaban por lo mismo /^uri_que_viene$/
            $regExp = "/^".$regexp_uri."$/";

            $validate_uri = preg_match($regExp, $this->uri);
           
   
            if( $this->method == $method_must && $validate_uri){
               
                $controller = new $controller();
                $controller -> $action( $id );
            }
        }

        public function manageUris(){
           
            
            $this->request( "GET", "/", "WebController", "index");
            $this->request( "GET", "/page/:id", "WebController", "index");

            $this->request( "GET", "/login", "WebController", "login");
            $this->request( "GET", "/signup", "WebController", "signup");

            // POST    /signup        CREAR USARIO
            $this->request( "POST", "/signup", "UserController", "create");

            // POST    /login        Login USARIO
            $this->request( "POST", "/login", "UserController", "login");
            
            // POST    /logout        Logout USARIO
            $this->request( "POST", "/logout", "UserController", "logout");

            $this->request( "GET", "/profile", "UserController", "profile");
            $this->request( "GET", "/profile/edit", "UserController", "edit_view");
            $this->request( "POST", "/profile/edit", "UserController", "update");
            $this->request( "POST", "/profile/changeEmail", "UserController", "change_email");
            $this->request( "POST", "/profile/changePassword", "UserController", "change_password");


            // Vista de creación de artículo
            $this->request( "GET", "/article/new", "ArticleController", "new");

            // Creación de artículo
            $this->request( "POST", "/article/new", "ArticleController", "create");

            // Visualización de artículo /article/{id}
            $this->request( "GET", "/article/:id", "ArticleController", "show");
            
            // Vista de Edición de un artículo /article/edit/{id}
            $this->request( "GET", "/article/edit/:id", "ArticleController", "edit_view");

            // Vista de Edición de un artículo /article/edit/{id}
            $this->request( "POST", "/article/edit/:id", "ArticleController", "update");
        } 
    
    }
    



?>