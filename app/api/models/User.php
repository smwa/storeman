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
    $password
    $salt;
  
  public function setPassword($password, $salt) {
    if (!$this->testPassword($password)) return false;
    $this->salt = self::generateSalt();
    $this->password = self::hash($password, $this->salt);
    return $this->password;
  }
  
  public static function hash($password, $salt) {
    return password_hash($password, PASSWORD_BCRYPT, array("cost" => '10', "salt" => $salt));
  }
  
  private function testPassword($password) {
    if (strlen($password) < 8) {
        return false;
    }
    return true;
  }
  
  public static function generateSalt() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string = '';
    for ($i = 0; $i < 128; $i++) {
      $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }
    return $string;
  }
}
