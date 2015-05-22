<?php

class containersRoute extends rest
{
  protected $requiresAuth = true;
  
  function get() {
    if ($this->id) {
      $c = Container::findOne(array("userid" => $this->user->id, "id" => $this->id));
      if (!$c) {
        return $this->error("Invalid container");
      }
      return array(
        "id" => $c->id,
        "title" => $c->title,
        "location" => $c->locationid,
      );
    }
    
    $ret = array();
    $this->user->populate("Containers");
    foreach ($this->user->Containers as $c) {
      $ret[] = array(
        "id" => $c->id,
        "title" => $c->title,
        "location" => $c->locationid,
      );
    }
    return $ret;
  }
  
  function post() {
    if (!$this->input["title"]) {
      return $this->error("Invalid title");
    }
    $this->input["location"] = intval($this->input["location"]);
    if ($this->input["location"] > 0) {
      $ls = Location::findOne(array("userid" => $this->user->id, "id" => $this->input["location"]));
      if (!$ls) {
        return $this->error("Invalid location");
      }
    }
    $c = new Container();
    $c->userid = $this->user->id;
    $c->locationid = $this->input["location"];
    $c->title = $this->input["title"];
    $c->save();
    return array(
      "id" => $c->id,
      "title" => $c->title,
      "location" => $c->locationid,
    );
  }
  
  function put() {
    $c = Container::findOne(array("userid" => $this->user->id, "id" => $this->id));
    if (!$c) {
      return $this->error("Invalid container");
    }
    if (!$this->input["title"]) {
      return $this->error("Invalid title");
    }
    $this->input["location"] = intval($this->input["location"]);
    if ($this->input["location"] > 0) {
      $ls = Location::findOne(array("userid" => $this->user->id, "id" => $this->input["location"]));
      if (!$ls) {
        return $this->error("Invalid location");
      }
    }
    $c->title = $this->input["title"];
    $c->locationid = $this->input["location"];
    $c->save();
    return array(
      "id" => $c->id,
      "title" => $c->title,
      "location" => $c->locationid,
    );
  }
  
  function delete() {
    $c = Container::findOne(array("userid" => $this->user->id, "id" => $this->id));
    if (!$c) {
      return $this->error("Invalid container");
    }
    
    $is = Item::find(array("userid" => $this->user->id, "locationid" => $l->id));
    foreach ($is as $i) {
      $i->locationid = 0;
      $i->save();
    }
    $c->delete();
  }
}
