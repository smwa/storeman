<?php

class dataRoute extends rest
{
  protected $requiresAuth = true;
  
  function get() {
    $this->user->Populate();
    foreach ((array)$this->user->Containers as $c) {
      $c->populate("Images");
      foreach ($c->Images as $key => $img) {
        $c->Images[$key]->filedata = utf8_encode($img->filedata);
      }
    }
    foreach ((array)$this->user->Items as $i) {
      $i->populate("Images");
      foreach ($i->Images as $key => $img) {
        $i->Images[$key]->filedata = utf8_encode($img->filedata);
      }
    }
    unset($this->user->Sessions);
    unset($this->user->password);
	$this->header('Content-disposition: attachment; filename=storeman.json');
    return json_encode((array)$this->user, JSON_PRETTY_PRINT);
  }
  
  function post() {

  }
}
