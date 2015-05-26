<?php

class dataRoute extends rest
{
  protected $requiresAuth = true;
  
  function get() {
    $this->user->Populate();
    unset($this->user->Sessions);
    unset($this->user->password);
	$this->header('Content-disposition: attachment; filename=storeman.json');
    return (array)$this->user;
  }
  
  function post() {

  }
}
