<?php
class Containerimage extends MysqlActiveRecord {
  protected function getPrimaryKey() {
        return "id";
    }
    protected function getTableName() {
        return "containerimages";
    }
    
    public function uploadFromLocation($location) {
        try {
            $ir = new \Eventviva\ImageResize($location);
            $ir->resizeToWidth(600);
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
    public $containerid;
    public $filename;
    public $filedata;
}
