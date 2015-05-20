<?php
include_once "rest.php";
include_once "ActiveRecord.php";
include_once "MysqlActiveRecord.php";

function autoloadModels($class) {
  if (!strpos($class, "Route")) {
    include_once("models/".$class);
  }
}

spl_autoload_register("autoloadModels");

$user=null;

$rest = rest::getRoute("routes");
$rest->process($user);
