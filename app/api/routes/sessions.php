<?php

class sessionsRoute extends rest
{    
  function post() {
    $user = User::findOne(array("email" => $this->input["email"]));
    if (!$user) {
      return $this->error("This email has not been registered", self::HTTP_UNAUTHORIZED);
    }
    if ($user->password != User::hash($this->input["password"])) {
      return $this->error("Incorrect password", self::HTTP_UNAUTHORIZED);
    }
    $Session = new Session();
    $Session->userid = $user->id;
    $Session->save();
    setcookie("sessionid", $Session->sessionid);
    return array("sessionid" => $Session->sessionid);
  }
  
  function delete() {
    $session = Session::findOne(array("sessionid" => $_REQUEST["sessionid"]));
    if ($session) {
      $session->delete();
    }
    setcookie("sessionid", "", time() - 3600);
  }
}
