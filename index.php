<?php
  // define __ROOT_DIR constant which contains the absolute path on disk
  // of the directory that contains this file (index.php)
  // e.g. http://isic.mines-douai.fr/web01/index.php => __ROOT_DIR = /home/web01/public_html
  $rootDirectoryPath = realpath(dirname(__FILE__));
  define ('__ROOT_DIR', $rootDirectoryPath );

  // define __BASE_URL constant which contains the URL PATH of the index.php
  // e.g. http://isic.mines-douai.fr/web01/index.php => __BASE_URL = /web01
  $base_url = explode('/',$_SERVER['PHP_SELF']);
  array_pop($base_url);
  define ('__BASE_URL', implode('/',$base_url) );

  $session_status = false;
  function SessionStart(){
    if( $GLOBALS['session_status'] != true ){
      session_start();
      $GLOBALS['session_status'] = true;
    }
  }

  function SessionStop(){
    if( $GLOBALS['session_status'] != false ){
      session_unset();
      session_destroy();
      session_write_close();
      setcookie("PHPSESSID");
      $GLOBALS['session_status'] = false;
    }
  }

  // Load all application config
  require_once(__ROOT_DIR . "/config/config.php");

  // Load the Loader class to automatically load classes when needed
  require_once(__ROOT_DIR . '/classes/AutoLoader.class.php');



  // Reify the current request
  $request = Request::getCurrentRequest();


  try {
    // Instantiate the adequat controller according to the current request
    $controller = Dispatcher::dispatch($request);
    // Execute the requested action
    $controller->execute();
  } catch (Exception $e) {
    echo 'Error : ' . $e->getMessage() . "\n";
  }
?>
