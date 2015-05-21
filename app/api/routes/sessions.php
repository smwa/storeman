<?php

class sessionsRoute extends rest
{
  protected $deleteRequiresAuth = true;
    
  function post() {
    $user = User::findOne(array("email" => $this->input["email"]));
    if (!$user) {
      return $this->error("Invalid email address", self::HTTP_UNAUTHORIZED);
    }
    if ($user->password != User::hash($this->input["password"])) {
      return $this->error("Invalid password", self::HTTP_UNAUTHORIZED);
    }
    $Session = new Session();
    $Session->userid = $user->id;
    $Session->save();
    setcookie("sessionid", $Session->sessionid);
    return array("sessionid" => $Session->sessionid);
  }
  
  function delete() {
    $session = Session::findOne(array("sessionid" => $_REQUEST["sessionid"]));
    if (!$session) {
      return $this->error("Invalid session", self::HTTP_BAD_REQUEST);
    }
    $session->delete();
    setcookie("sessionid", "", time() - 3600);
  }
}
