<?php

  // Receptor de TODAS las peticiones
  require_once($_SERVER['DOCUMENT_ROOT']."/config/ini.php");

  // Preguntar si la session está abierta o no
  // $session 
  $session = new Session();

  $rc = new RouterController();
  $rc->manageUris();
    

?>