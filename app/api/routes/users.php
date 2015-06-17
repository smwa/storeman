<?php

class usersRoute extends rest
{
  protected $getRequiresAuth = true;
  protected $putRequiresAuth = true;
  protected $deleteRequiresAuth = true;
  
  function get() {
    return array(
      "id" => $this->user->id,
      "email" => $this->user->email,
    );
  }
  
  function post() {
    if (!$this->input["email"] || !$this->input["password"]) {
      return $this->error("Missing parameters", self::HTTP_BAD_REQUEST);
    }
    $OtherUser = User::findOne(array("email" => $this->input["email"]));
    if ($OtherUser) {
      return $this->error("This email is already in use", self::HTTP_BAD_REQUEST);
    }
    $User = new User();
    $User->email = $this->input["email"];
    if (!$User->setPassword($this->input["password"])) {
      return $this->error("The password does not meet the minimum requirements(at least 8 characters)", self::HTTP_BAD_REQUEST);
    }
    $User->save();
    return array(
      "id" => $User->id,
      "email" => $User->email,
    );
  }
  
  function put() {
    if ($this->user->password != User::hash($this->input["oldpassword"], $this->user->salt)) {
      return $this->error("Invalid password: ".$this->input["oldpassword"], self::HTTP_UNAUTHORIZED);
    }
    if (!$this->user->setPassword($this->input["password"])) {
      return $this->error("The password does not meet the minimum requirements(at least 8 characters)", self::HTTP_BAD_REQUEST);
    }
    $this->user->save();
    return array(
      "id" => $this->user->id,
      "email" => $this->user->email,
    );
  }
  
  function delete() {
    if ($this->user->password != User::hash($this->input["password"], $this->user->salt)) {
      return $this->error("Invalid password", self::HTTP_UNAUTHORIZED);
    }
    
    $userdata = array(
      Location::find(array("userid" => $this->user->id)),
      Container::find(array("userid" => $this->user->id)),
      Item::find(array("userid" => $this->user->id)),
      Session::find(array("userid" => $this->user->id)),
    );
    $userdata[] = Containerimage::find(array("containerid" => $userdata[1]));
    $userdata[] = Itemimage::find(array("itemid" => $userdata[2]));
    $this->user->delete();
    foreach ($userdata as $array) {
      if (!$array) continue;
      foreach ($array as $obj) {
        $obj->delete();
      }
    }
  }
}
