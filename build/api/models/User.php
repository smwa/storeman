<?php

class User extends MysqlActiveRecord {
  protected function getPrimaryKey() {
    return "id";
  }
  protected function getTableName() {
    return "users";
  }

  protected function getRelations() {
    return array(
      "Sessions" => array(
        "relation" => self::has,
        "model"     => "Session",
        "localkey" => "id",
        "foreignkey" => "userid"
      ),
      "Locations" => array(
        "relation" => self::has,
        "model"     => "Location",
        "localkey" => "id",
        "foreignkey" => "userid"
      ),
      "Containers" => array(
        "relation" => self::has,
        "model"     => "Container",
        "localkey" => "id",
        "foreignkey" => "userid"
      ),
      "Items" => array(
        "relation" => self::has,
        "model"     => "Item",
        "localkey" => "id",
        "foreignkey" => "userid"
      ),
    );
  }

  public $id,
    $email,
    $password;
  
  public function setPassword($password) {
    if (!$this->testPassword($password)) return false;
    $this->password = self::hash($password);
    return $this->password;
  }
  
  public static function hash($password) {
    return password_hash($password, PASSWORD_BCRYPT, array("cost" => '10', "salt" => $GLOBALS["salt"]));
  }
  
  private function testPassword($password) {
    if (strlen($password) < 8) {
        return false;
    }
    return true;
  }
}
