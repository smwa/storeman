<?php
class Itemimage extends MysqlActiveRecord {
    protected function getPrimaryKey() {
        return "id";
    }
    protected function getTableName() {
        return "itemimages";
    }
  
    public function uploadFromLocation($location) {
        $this->filedata = file_get_contents($location);
        //16777215 is the number of bytes for a mediumblob
        if ($this->filedata === false || strlen($this->filedata) > 16777215) {
          $this->filedata = null;
          return false;
        }
        return true;
    }

    public $id;
    public $itemid;
    public $filename;
    public $filedata;
}
