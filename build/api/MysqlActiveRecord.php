<?php

abstract class MysqlActiveRecord extends ActiveRecord {
    protected function getConnection() {
        return new PDO('mysql:host='.$GLOBALS["mysqli_host"].';port='.$GLOBALS["mysqli_port"].';dbname='.$GLOBALS["mysqli_db"], $GLOBALS["mysqli_user"], $GLOBALS["mysqli_pass"], array( PDO::ATTR_PERSISTENT => false));
    }

    protected function getDatabaseName() {
        return "MySQL";
    }

    protected function protectedFind($connection, $ValuesToFetch, $ValuesToSelectBy, $Start, $Limit, $Order) {
        /* @var $connection PDO */
        $Query = "select ".implode(", ", $ValuesToFetch)." from ".$this->getTableName()." ";
        $data = array();
        $Query .= $this->buildWhere($ValuesToSelectBy, $data);
        if (!empty($Order)) {
            $Query .= "ORDER BY ".implode(", ", $Order)." ";
        }
        $Query .= "LIMIT $Start,$Limit ";
        $statement = $connection->prepare($Query);
        $statement->execute($data);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function protectedUpdate($connection, $ValuesToSave, $ValuesToSelectBy, $Limit) {
        /* @var $connection PDO */
        $Updates = array();
        $data = array();
        foreach ($ValuesToSave as $key => $value) {
            $Updates[] = "$key = ?";
            $data[] = $value;
        }
        $Query = "UPDATE ".$this->getTableName()." SET ".implode(", ", $Updates)." ".$this->buildWhere($ValuesToSelectBy, $data)." LIMIT $Limit ";
        $statement = $connection->prepare($Query);
        $statement->execute($data);
    }

    protected function protectedInsert($connection, $ValuesToSave) {
        /* @var $connection PDO */
        $Query = "INSERT INTO ".$this->getTableName()."(".implode(",", array_keys($ValuesToSave)).") VALUES (".implode(",",array_pad(array(),count($ValuesToSave),"?")).") ";
        $statement = $connection->prepare($Query);
        $statement->execute(array_values($ValuesToSave));
        return $connection->lastInsertId();

    }

    protected function protectedDelete($connection, $ValuesToSelectBy, $Limit) {
        /* @var $connection PDO */
        $Query = "DELETE FROM ".$this->getTableName()." ".$this->buildWhere($ValuesToSelectBy, $data)." LIMIT $Limit ";
        $statement = $connection->prepare($Query);
        $statement->execute($data);
    }

    private function buildWhere($Parameters, &$data) {
        $Query = "";
        if (!empty($Parameters)) {
            $Query .= "WHERE ";
            foreach ($Parameters as $column => $val) {
                if (is_array($val)) {
                    $Query .= $column." IN(".implode(',', array_fill(0, count($val), '?')).") ";
                    $data = array_merge($data, $val);
                }
                elseif (is_string($val) && (substr($val, 0, 1) == ">" || substr($val, 0, 1) == "<")) {
                    $Query .= $column." ".trim(substr($val,0,1))." ? ";
                    $data[] = trim(substr($val,1));
                }
                elseif (is_string($val) && (substr($val, 0, 2) == ">=" || substr($val, 0, 2) == "<=")) {
                    $Query .= $column." ".trim(substr($val,0,2))." ? ";
                    $data[] = trim(substr($val,2));
                }
                else {
                    $Query .= $column." = ? ";
                    $data[] = trim($val);
                }
                $Query .= "AND ";
            }
            $Query = substr($Query, 0, -4);
            return $Query;
        }
        return "";
    }
}
