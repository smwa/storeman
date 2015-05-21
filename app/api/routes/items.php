<?php

class itemsRoute extends rest
{
  protected $requiresAuth = true;
  
  function get() {
    if ($this->id) {
      $c = Item::findOne(array("userid" => $this->user->id, "id" => $this->id));
      if (!$c) {
        return $this->error("Invalid item");
      }
      return array(
        "id" => $c->id,
        "title" => $c->title,
        "location" => $c->locationid,
        "container" => $c->containerid,
      );
    }
    
    $ret = array();
    $this->user->populate("Containers");
    foreach ($this->user->Containers as $c) {
      $ret[] = array(
        "id" => $c->id,
        "title" => $c->title,
        "location" => $c->locationid,
        "container" => $c->containerid,
      );
    }
    return $ret;
  }
  
  function post() {
    $in = $this->input;
    if (!$in["title"]) {
      return $this->error("Invalid title");
    }
    $loc = Location::findOne(array("userid" => $this->user->id, "id" => $in["location"]));
    if (!$loc) {
      return $this->error("Invalid location");
    }
    $con = Container::findOne(array("userid" => $this->user->id, "id" => $in["container"]));
    if (!$con) {
      return $this->error("Invalid container");
    }
    $i = new Item();
    $i->userid = $this->user->id;
    $i->title = $in["title"];
    $i->locationid = $in["location"];
    $i->containerid = $in["container"];
    $i->save();
  }
  
  function put() {
    $i = Item::findOne(array("userid" => $this->user->id, "id" => $this->id));
    if (!$i) {
      return $this->error("Invalid item");
    }
    $in = $this->input;
    if (!$in["title"]) {
      return $this->error("Invalid title");
    }
    $loc = Location::findOne(array("userid" => $this->user->id, "id" => $in["location"]));
    if (!$loc) {
      return $this->error("Invalid location");
    }
    $con = Container::findOne(array("userid" => $this->user->id, "id" => $in["container"]));
    if (!$con) {
      return $this->error("Invalid container");
    }
    $i->title = $in["title"];
    $i->locationid = $in["location"];
    $i->containerid = $in["container"];
    $i->save();
  }
  
  function delete() {
    $c = Item::findOne(array("userid" => $this->user->id, "id" => $this->id));
    if (!$c) {
      return $this->error("Invalid item");
    }
    $c->delete();
  }
}
