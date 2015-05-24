<?php

class locationsRoute extends rest
{
  protected $requiresAuth = true;
  
  function get() {
    if ($this->id) {
      $l = Location::findOne(array("id" => $this->id, "userid" => $this->user->id));
      if (!$l) {
        return $this->error("Invalid location");
      }
      return array(
        "id" => $l->id,
        "user" => $l->userid,
        "title" => $l->title,
        "description" => $l->description,
      );
    }
    
    $ls = Location::find(array("userid" => $this->user->id));
    $ret = array();
    foreach ($ls as $l) {
      $ret[] = array(
        "id" => $l->id,
        "title" => $l->title,
      );
    }
    return $ret;
  }
  
  function post() {
    if (!$this->input["title"]) {
      return $this->error("Invalid title");
    }
    $l = new Location();
    $l->userid = $this->user->id;
    $l->title = $this->input["title"];
    $l->description = $this->input["description"];
    $l->save();
    return array(
      "id" => $l->id,
      "user" => $l->userid,
      "title" => $l->title,
      "description" => $l->description,
    );
  }
  
  function put() {
    $l = Location::findOne(array("id" => $this->id, "userid" => $this->user->id));
    if (!$l) {
      return $this->error("Invalid location");
    }
    if (!$this->input["title"]) {
      return $this->error("Invalid title");
    }
    $l->title = $this->input["title"];
    $l->description = $this->input["description"];
    $l->save();
    return array(
      "id" => $l->id,
      "user" => $l->userid,
      "title" => $l->title,
      "description" => $l->description,
    );
  }
  
  function delete() {
    $l = Location::findOne(array("id" => $this->id, "userid" => $this->user->id));
    if (!$l) {
      return $this->error("Invalid location");
    }
    
    $cs = Container::find(array("userid" => $this->user->id, "locationid" => $l->id));
    $is = Item::find(array("userid" => $this->user->id, "locationid" => $l->id));
    foreach ($cs as $c) {
      $c->locationid = 0;
      $c->save();
    }
    foreach ($is as $i) {
      $i->locationid = 0;
      $i->save();
    }
    $l->delete();
  }
}
