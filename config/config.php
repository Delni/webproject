<?php
  if(isset($_COOKIE['PHPSESSID'])){
    SessionStart();
  }

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
?>
