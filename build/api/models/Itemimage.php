<?php
include_once("php-image-resize.php");
class Itemimage extends MysqlActiveRecord {
    protected function getPrimaryKey() {
        return "id";
    }
    protected function getTableName() {
        return "itemimages";
    }
  
    public function uploadFromLocation($location) {
        try {
            $ir = new \Eventviva\ImageResize($location);
            $ir->resizeToWidth($GLOBALS["imageresizewidth"]);
            $this->filedata = $ir->getImageAsString();
        } catch (Exception $e) {
            error_log('ImageResize caught exception: '.$e->getMessage());
        }
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
