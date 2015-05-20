<?php

abstract class ActiveRecord {
    const belongsTo = "belongsTo";
    const has = "has";

    public static function find($query = null, $start = 0, $limit = 1000) {
        $reference = new static();
        if (!is_array($query)) {
            $query = array();
        }
        $start = max(0, intval($start));
        $ValuesToFetch = array_keys($reference->getColumns());
        $ValuesToFetch[] = $reference->getPrimaryKey();
        $results = $reference->protectedFind($reference->getConnectionSingleton(), $ValuesToFetch, $query, $start, $limit, array($reference->getPrimaryKey()." ASC"));
        $return = array();
        foreach ($results as $row) {
            $r = new static();
            foreach ($row as $key => $val) {
                $r->$key = $val;
            }
            $return[] = $r;
        }
        return $return;
    }

    public static function findOne($Query) {
        $reference = new static();
        if (!is_array($Query)) {
            $Query = array($reference->getPrimaryKey() => $Query);
        }
        $r = $reference->find($Query, 0, 1);
        if ($r) return $r[0];
        return null;
    }

    public function save() {
        if ($this->{$this->getPrimaryKey()} === null) {
            $this->{$this->getPrimaryKey()} = $this->protectedInsert($this->getConnectionSingleton(), $this->getColumns());
        } else {
            $this->protectedUpdate($this->getConnectionSingleton(), $this->getColumns(), array($this->getPrimaryKey() => $this->{$this->getPrimaryKey()}), 1);
        }
        return $this->{$this->getPrimaryKey()};
    }

    public function delete() {
        $this->protectedDelete($this->getConnectionSingleton(), array($this->getPrimaryKey() => $this->{$this->getPrimaryKey()}), 1);
        return true;
    }

    public function populate($models = null) {
        switch (gettype($models)) {
            case "string":
                $models = array($models);
                break;
            case "array":
                if (empty($models)) return;
                break;
            default:
                foreach ($this->getRelations() as $v => $r) {
                    $this->populate($v);
                }
                return;
        }
        $relations = $this->getRelations();
        $relationVariable = array_shift($models);
        if (!isset($relations[$relationVariable])) {
            throw new Exception("Invalid Populate Name");
        }
        switch ($relations[$relationVariable]["relation"]) {
            case self::belongsTo:
                $this->populateManyToOne($relationVariable, $relations[$relationVariable]);
                break;
            case self::has:
                $this->populateOneToMany($relationVariable, $relations[$relationVariable]);
                break;
            default:
                throw new Exception("Undefined Relationship");
        }
        if (!empty($models)) {
            if (is_object($this->$relationVariable)) {
                $this->{$relationVariable}->populate($models);
            } else {
                foreach ($this->$relationVariable as $k => $v) {
                    $v->populate($models);
                }
            }
        }
    }
    private function populateManyToOne($variable, $relation) {
        $model = $relation["model"];
        $this->$variable = $model::findOne(array($relation["foreignkey"] => $this->{$relation["localkey"]}));
    }
    private function populateOneToMany($variable, $relation) {
        $model = $relation["model"];
        $this->$variable = $model::find(array($relation["foreignkey"] => $this->{$relation["localkey"]}));
    }

    private function getColumns() {
        $columns = get_object_vars($this);
        unset($columns[$this->getPrimaryKey()]);
        foreach ($this->getRelations() as $relationVariable => $relationArray) {
            if (isset($columns[$relationVariable])) {
                unset($columns[$relationVariable]);
            }
        }
        return $columns;
    }

    private function getConnectionSingleton() {
        global $connections;
        $t = $connections[$this->getDatabaseName()];
        if (null === $t) {
            $t = $connections[$this->getDatabaseName()] = $this->getConnection();
        }
        return $t;
    }

    abstract protected function getConnection();
    abstract protected function getDatabaseName(); //i.e. MySQL, MongoDB, MySQL2
    abstract protected function protectedFind($connection, $ValuesToFetch, $ValuesToSelectBy, $Start, $Limit, $Order);
    abstract protected function protectedUpdate($connection, $ValuesToSave, $ValuesToSelectBy, $Limit);
    abstract protected function protectedInsert($connection, $ValuesToSave);
    abstract protected function protectedDelete($connection, $ValuesToSelectBy, $Limit);

    abstract protected function getTableName();
    abstract protected function getPrimaryKey();
    protected function getRelations() {
        return array();
    }
}
