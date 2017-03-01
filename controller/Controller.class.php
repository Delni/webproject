<?php
  abstract class Controller extends MyObject {
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
