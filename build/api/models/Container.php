<?php

class Container extends MysqlActiveRecord {
    protected function getPrimaryKey() {
        return "id";
    }
    protected function getTableName() {
        return "containers";
    }

    protected function getRelations() {
        return array(
            "User" => array(
                "relation" => self::belongsTo,
                "model"     => "User",
                "localkey" => "userid",
                "foreignkey" => "id"
            ),
            "Items" => array(
                "relation" => self::has,
                "model"     => "Item",
                "localkey" => "id",
                "foreignkey" => "containerid"
            ),
            "Location" => array(
                "relation" => self::belongsTo,
                "model"     => "Location",
                "localkey" => "locationid",
                "foreignkey" => "id"
            ),
            "Images" => array(
                "relation" => self::has,
                "model"     => "Containerimage",
                "localkey" => "id",
                "foreignkey" => "containerid"
            ),
        );
    }

    public $id,
        $userid,
        $title,
        $locationid;
}
