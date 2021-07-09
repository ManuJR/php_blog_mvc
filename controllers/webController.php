<?php

    class WebController
    {
        
        public function __construct( )
        {   
          
        }

        
        public function index(){
          global $session;
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