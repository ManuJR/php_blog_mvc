<?php
  echo "index";
  // Receptor de TODAS las peticiones
  const BASE_FOLDER="/blog";

  require_once($_SERVER['DOCUMENT_ROOT'].BASE_FOLDER."/config/ini.php");

  // Preguntar si la session está abierta o no
  // $session 
  $session = new Session();

  $rc = new RouterController();
  $rc->manageUris();
  print_r($rc);

?>