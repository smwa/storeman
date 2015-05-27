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
    $f = new Containerimage();
    $f->filename = $_FILES['file']['name'];
    if (!$f->blah($_FILES['file']['tmp_name'])) {
        return $this->error("Invalid file");
    }
    $f->itemid = intval($this->id);
    $f->save();
  }
  
  function delete() {
    $c = Container::findOne(array("userid" => $this->user->id, "id" => intval($this->id)));
    if (!$c) {
      return $this->error("Invalid container");
    }
    $ci = Containerimage::findOne(array("containerid" => intval($this->id)));
    $ci->delete();
  }
}
