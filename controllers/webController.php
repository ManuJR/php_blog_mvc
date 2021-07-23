<?php

$session;
    class WebController
    {

        public function __construct( )
        {   
          
        }

        
        public function index( $page=1 ){
          global $session;

          $paginator = new Paginator( $page);

          $articles = Article::list( $paginator -> limit,   $paginator -> offset );
          
          require_once($_SERVER['DOCUMENT_ROOT']."/views/web/index.php");

        }

        public function login(){
          global $session;
          require_once($_SERVER['DOCUMENT_ROOT']."/views/user/login.php");

        }

        public function signup(){
          global $session;
          require_once($_SERVER['DOCUMENT_ROOT']."/views/user/signup.php");

        }

    }

?>