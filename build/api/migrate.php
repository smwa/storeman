<?php
require_once("config.php");
$link = new mysqli($GLOBALS["mysqli_host"],$GLOBALS["mysqli_user"],$GLOBALS["mysqli_pass"], "", $GLOBALS["mysqli_port"], $GLOBALS["mysqli_socket"]);
if (mysqli_connect_errno()) {
  printf("Connect failed: %s\n", mysqli_connect_error());
  exit();
}
//FOR DEVELOPMENT, uncomment to drop to v0
// $link->query("DROP DATABASE ".$GLOBALS["mysqli_db"]);
// echo "Dropped";
// exit();
if (!$link->select_db($GLOBALS["mysqli_db"])) {
  $current_version = 0;
  $sql = 'CREATE DATABASE '.$GLOBALS["mysqli_db"];
  if ($link->query($sql)) {
      echo "Database ".$GLOBALS["mysqli_db"]." created successfully"."<br>";
  } else {
      echo 'Error creating database: ' . $link->error ."<br>";
  }
  $link->select_db($GLOBALS["mysqli_db"]);
} else {
  $sql = "SELECT database_version FROM config ";
  $result = $link->query($sql);
  $row = mysqli_fetch_assoc($result);
  $current_version = $row["database_version"];
  if (!$row) {
    $current_version = 0;
    echo "Failed to select version"."<br>";
  }
}
echo "Current version: ".$current_version."; Desired version: ".$GLOBALS["db_version"]."<br>";
while ($current_version < $GLOBALS["db_version"]) {
  $current_version++;
  $link->multi_query(file_get_contents("../../sql/v".$current_version.".sql"));
  if ($link->error) {
    echo "Error on v".$current_version.": ".$link->error."<br>";
    exit();
  }
  echo "Upgraded from v".($current_version - 1)." to v".$current_version."<br>";
}
$link->query("UPDATE config SET database_version = ".$GLOBALS["db_version"]);
$link->close();
