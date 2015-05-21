<?php

class Location extends MysqlActiveRecord {
    protected function getPrimaryKey() {
        return "id";
    }
    protected function getTableName() {
        return "locations";
    }

    protected function getRelations() {
        return array(
            "User" => array(
                "relation" => self::belongsTo,
                "model"     => "User",
                "localkey" => "userid",
                "foreignkey" => "id"
            ),
            "Containers" => array(
                "relation" => self::has,
                "model"     => "Container",
                "localkey" => "id",
                "foreignkey" => "locationid"
            ),
            "Items" => array(
                "relation" => self::has,
                "model"     => "Item",
                "localkey" => "id",
                "foreignkey" => "locationid"
            ),
        );
    }

    public $id,
        $userid,
        $title,
        $description;
}
