<?php

class UserGroup extends MysqlActiveRecord {
    protected function getPrimaryKey() {
        return "id";
    }
    protected function getTableName() {
        return "artest";
    }

    protected function getRelations() {
        return array(
            "Client" => array(
                "relation" => self::has,
                "model"     => "Client",
                "localkey" => "first",
                "foreignkey" => "clientcode"
            ),
        );
    }

    public $id,
        $first,
        $second;
}
