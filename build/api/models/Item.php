<?php

class Item extends MysqlActiveRecord {
    protected function getPrimaryKey() {
        return "id";
    }
    protected function getTableName() {
        return "items";
    }

    protected function getRelations() {
        return array(
            "User" => array(
                "relation" => self::belongsTo,
                "model"     => "User",
                "localkey" => "userid",
                "foreignkey" => "id"
            ),
            "Container" => array(
                  "relation" => self::belongsTo,
                  "model"     => "Container",
                  "localkey" => "containerid",
                  "foreignkey" => "id"
              ),
            "Location" => array(
                  "relation" => self::belongsTo,
                  "model"     => "Location",
                  "localkey" => "locationid",
                  "foreignkey" => "id"
              ),
            "Images" => array(
                "relation" => self::has,
                "model"     => "Itemimage",
                "localkey" => "id",
                "foreignkey" => "itemid"
            ),
        );
    }

    public $id,
        $userid,
        $locationid,
        $containerid,
        $title;
}
