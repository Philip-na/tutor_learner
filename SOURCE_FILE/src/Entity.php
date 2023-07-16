<?php

use PhpParser\Node\Expr\Cast\Object_;
abstract class Entity {
    protected $tableName;
    protected $fields;
    protected $dbc;
    protected $primaryKeys = ['id'];

    // enty constractor

    protected function __construct($dbc, $tableName) {
        $this->dbc = $dbc;
        $this->tableName = $tableName;
        $this->tableFields();
    }

    // set the entity fields as in the database
    abstract protected function tableFields();


    // get a sigle record from the database
    public function findBy($conditions, $operator = '') {
        $results = $this->find($conditions, $operator);
        if ($results && $results[0]) {
            $this->setValues($results[0]);
        }
    }

    // gets mulitple records froms the database

    public function findAll($conditions = [], $operator = '') {
        $results = [];
        if(empty($conditions) || $operator == ''){
            $databaseData = $this->find();
        }else{
            $databaseData = $this->find($conditions, $operator);
        }

        if ($databaseData) {
            $className = static::class;
            foreach ($databaseData as $objectData) {
                $object = new $className($this->dbc);
                $object = $this->setValues($objectData, $object);
                $results[] = $object;
            }
        }
        return $results;
    }

    public function setValues($value, $object = null) {
        if ($object === null) {
            $object = $this;
        }
        foreach ($object->primaryKeys as $keyName) {
            if (isset($value[$keyName])) {
                $object->$keyName = $value[$keyName];
            }
        }
        foreach ($this->fields as $fieldName) {
            if (isset($value[$fieldName])) {
                $object->$fieldName = $value[$fieldName] ?? '';
            }
        }
        return $object;
    }

    protected function find(array $conditions = [], $operator = '') {
        $preparedFields = [];
        $sql = "SELECT * FROM " . $this->tableName;
    
        if (!empty($conditions)) {
            $sql .= " WHERE ";
            $bindings = [];
            $operators = ['AND', 'OR'];
    
            foreach ($conditions as $fieldName => $fieldValue) {
                $bindings[] = "{$fieldName} = :{$fieldName}";
                $preparedFields[$fieldName] = $fieldValue;
            }
    
            if ($operator && in_array(strtoupper($operator), $operators)) {
                $sql .= implode(" {$operator} ", $bindings);
            } else {
                $sql .= implode(" AND ", $bindings);
            }
        }
    
        $stmt = $this->dbc->prepare($sql);
        $stmt->execute($preparedFields);
        $databaseData = $stmt->fetchAll();
    
        return $databaseData;
    }
    

    public function save() {
        if ($this->isExistingRecord()) {
            $this->update();
        } else {
            $this->insert();
        }
    }

    private function isExistingRecord() {
        foreach ($this->primaryKeys as $keyname) {
            if (empty($this->$keyname)) {
                return false;
            }
        }
        return true;
    }

    private function update() {
        $fieldBindings = [];
        $preparedFields = [];
        foreach ($this->fields as $fieldName) {
            $fieldBindings[] = "{$fieldName} = :{$fieldName}";
            $preparedFields[$fieldName] = $this->$fieldName;
        }
        $fieldBindingString = implode(', ', $fieldBindings);

        $keyBindings = [];
        foreach ($this->primaryKeys as $keyname) {
            $keyBindings[] = "{$keyname} = :{$keyname}";
            $preparedFields[$keyname] = $this->$keyname;
        }
        $keyBindingString = implode(' AND ', $keyBindings);

        $sql = "UPDATE " . $this->tableName . " SET " . $fieldBindingString . " WHERE " . $keyBindingString;
        $stmt = $this->dbc->prepare($sql);
        $stmt->execute($preparedFields);
    }

    private function insert() {
        $fieldNames = [];
        $fieldValues = [];
        $preparedFields = [];
        foreach ($this->fields as $fieldName) {
            $fieldNames[] = $fieldName;
            $fieldValues[] = ":{$fieldName}";
            $preparedFields[$fieldName] = $this->$fieldName;
        }
        $fieldNamesString = implode(', ', $fieldNames);
        $fieldValuesString = implode(', ', $fieldValues);

        $sql = "INSERT INTO " . $this->tableName . " (" . $fieldNamesString . ") VALUES (" . $fieldValuesString . ")";
        // var_dump($sql);
        $stmt = $this->dbc->prepare($sql);
        $stmt->execute($preparedFields);
    }

    public function delete($conditions = []) {
        $keyBindings = [];
        $preparedFields = [];

        if(!empty($conditions)){
            foreach ($this->fields as $keyname) {

                if(isset($conditions[$keyname])){
                    $keyBindings[] = "{$keyname} = :{$keyname}";
                    $preparedFields[$keyname] = $conditions[$keyname];
                }      
            }
        }else{
            foreach ($this->primaryKeys as $keyname) {
                $keyBindings[] = "{$keyname} = :{$keyname}";
                $preparedFields[$keyname] = $this->$keyname;
            }
        }

       

        $keyBindingString = implode(' AND ', $keyBindings);

        $sql = "DELETE FROM " . $this->tableName . " WHERE " . $keyBindingString;
        $stmt = $this->dbc->prepare($sql);
        $stmt->execute($preparedFields);
    }
    public function setPostData($value, $setNullFields = true){
        $cleanData = [];
        foreach($this->fields as $field){
            if(!empty($value[$field])){
                $cleanData[$field] = trim($value[$field]);
            }else{
                if($setNullFields){
                    $cleanData[$field] = '';
                }                
            }
        }
        return $cleanData;
    }

    // special use
    public function yxz($modal, $cdtn = [],$field = ''){

        $x = new $modal($this->dbc);
        $x->findby($cdtn, "AND");
        if(property_exists($x,'id')){
            if($field == ''){
                
                return $x;
            }
            return $x->$field;
            
        }else{
            return [];
        }

    }
    


}
