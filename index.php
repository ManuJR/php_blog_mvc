<?php

  // Receptor de TODAS las peticiones
  require_once($_SERVER['DOCUMENT_ROOT']."/config/ini.php");

  $session = new Session();
  print_r($session);
  $rc = new RouterController();
  $rc->manageUris();
    

?>