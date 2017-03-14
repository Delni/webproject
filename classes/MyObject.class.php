<?php
  /*
  * Root class of all my classes
  */
  class MyObject {
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
