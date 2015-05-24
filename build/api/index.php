<?php
include_once "config.php";
include_once "rest.php";
include_once "ActiveRecord.php";
include_once "MysqlActiveRecord.php";

function autoloadModels($class) {
  if (!strpos($class, "Route")) {
    include_once("models/".$class.".php");
  }
}

spl_autoload_register("autoloadModels");

$userid = Session::getUserIDBySessionID($_COOKIE["sessionid"]);
$user = null;
if ($userid > 0) {
  $user = User::findOne($userid);
}

$rest = rest::getRoute("routes");
$rest->process($user);
