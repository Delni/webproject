<?php
  class MyObject {
    
    /**
    *   Root class of all my classes
    *   Handle general function, like log or error handler
    *
    *   Variables :
    *
    *   Function :
    *     @error_handler_popup    (void)    -> Create an alert, with great modularity
    *                                       -> color & title depend on the alert_type parameter
    *
    **/

    public function error_handler_popup($alert_type,$alert_key){
      if(isset($this->args[$alert_key])){
        echo '
        <div class="row text-left">
          <div class="col-sm-offset-4 col-sm-4 alert alert-'.$alert_type.' alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>'. ucfirst($alert_type) .' !</strong> ' .$this->args[$alert_key] . '
          </div>
        </div>
        <script>
          $(".alert").delay(2000).fadeTo(2000, 0)
        </script>';
      }
    }

  }
?>
