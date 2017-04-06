<?php
  abstract class Controller extends MyObject {

    /**
    *
    *   Define all the Controller basic function
    *
    *   Variables:
    *     @local_request     (object Request)    -> To get every info needed
    *
    *   Functions:
    *     @gdefaultAction  (void)    -> Should be define in subclasses
    *     @execute         (void)    -> Select action name in the request and execute this one
    *
    **/

    protected $local_request;

    public function __construct($request) {
      $this->local_request = $request;
    }

    abstract public function defaultAction($request);

    public function execute(){
      $action = $this->local_request->getActionName();
      $this->$action($this->local_request);
    }
  }
?>
