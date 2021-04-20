<?php


class Model {
    protected static $connection;
    protected $tableName;
    protected $idName;
    public $selects = null;

    public function __construct() {
        $this::$connection = new PDO('mysql:host=localhost:3306; dbname=stationery_shop; charset=utf8', 'developer', '|)eVel0per');
    }

    public function sqlQuery(string $sql){
        $set = self::$connection->query($sql);
        return $set->fetchAll(PDO::FETCH_ASSOC);
    }

    public function sqlExecute(string $sql, array $params) {
        $query = self::$connection->prepare($sql);
        $query->execute($params);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll() {
        $sql = "SELECT * FROM `$this->tableName`";
        return $this->sqlQuery($sql);
    }

    public function deleteById(int $id) {
        $sql = "DELETE FROM `$this->tableName` WHERE `$this->idName` = :id";
        $data = ['id' => $id];
        $this->sqlExecute($sql, $data);
    }

    //update only string field!
    public function updateFieldById(int $id, string $field, string $value) {
        $sql = "UPDATE `$this->tableName` SET `$field`=:value WHERE `$this->idName`=:id";
        $data = ['value' => $value, 'id' => $id];
        $this->sqlExecute($sql, $data);
    }

    public function initSelects() { }

    protected function parseFloat(string $str):float {
        $str = trim($str);
        $str = str_replace(',', '.', $str);
        return floatval($str);
    }

    protected function buildINStr(array $INItems) {
        $IN = "$INItems[0]";
        foreach ($INItems as $item) {
            $IN = $IN.','.$item;
        }
        $IN = '('.$IN.')';
        return $IN;
    }
}