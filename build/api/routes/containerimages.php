<?php

class containerimagesRoute extends rest
{
  protected $requiresAuth = true;
  
  function get() {
      $c = Container::findOne(array("userid" => $this->user->id, "id" => intval($this->id)));
      if (!$c) {
        return $this->error("Invalid container");
      }
      $ci = Containerimage::findOne(array("containerid" => intval($this->id)));
      if (!$ci) {
        return $this->error("Image not found", self::HTTP_NOT_FOUND);
      }
      switch(strtolower(substr($ci->filename, strrpos($ci->filename, ".")+1))) {
          case "gif":
              $imagetype = IMAGETYPE_GIF;
              break;
          case "bmp":
              $imagetype = IMAGETYPE_BMP;
              break;
          case "png":
          $imagetype = IMAGETYPE_PNG;
              break;
          default:
              $imagetype = IMAGETYPE_JPEG;
      }
      
      $this->contentType(image_type_to_mime_type($imagetype));
      return $ci->filedata;
  }
  
  function post() {
    $c = Container::findOne(array("userid" => $this->user->id, "id" => intval($this->id)));
    if (!$c) {
      return $this->error("Invalid container");
    }
    $ci = Containerimage::findOne(array("containerid" => intval($this->id)));
    if ($ci) {
      $ci->delete();
    }
    if ($_FILES["file"]["error"] > 0) {
      return $this->error("Container image upload error ".$_FILES["file"]["error"]);
    }
    $f = new Containerimage();
    $f->filename = $_FILES['file']['name'];
    if (!$f->uploadFromLocation($_FILES['file']['tmp_name'])) {
        return $this->error("Invalid file");
    }
    $f->containerid = intval($this->id);
    $f->save();
  }
  
  function delete() {
    $c = Container::findOne(array("userid" => $this->user->id, "id" => intval($this->id)));
    if (!$c) {
      return $this->error("Invalid container");
    }
    $ci = Containerimage::findOne(array("containerid" => intval($this->id)));
    if (!$ci) {
      return $this->error("Image not found", self::HTTP_NOT_FOUND);
    }
    $ci->delete();
  }
}
