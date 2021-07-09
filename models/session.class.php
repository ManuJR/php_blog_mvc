<?php
    class Session 
    {   
        private $isLogged;
        private $data;

        public function __construct()
        {   
            session_start();
            $this->isLogged     =   $this->isLogged();
            $this->data         =   $this->getData();
        }

        public function create( User $user ){
            $_SESSION['id']     = $user->id;
            $_SESSION['email']  = $user->email;
            $_SESSION['name']   = $user->name;
            $this->data     = $_SESSION;
            $this->isLogged = true;
        }

        public function destroy(){
            
        }

        public function isLogged(){
            if( isset($_SESSION['id']) && !empty($_SESSION['id']) &&
                isset($_SESSION['email']) && !empty($_SESSION['email']) &&
                isset($_SESSION['name']) && !empty($_SESSION['name'])
            ){
                return true;
            }
            return false;
        }

        public function getData(){
            
            return $_SESSION;
        }
        
        
    }
    


?>