<?php
include_once 'app/core/Model.php';

class ManufacturerModel extends Model
{
    const COLUMN_RUS_ASSOC = [
        'id_manufacturer' => 'ID',
        'name' => 'Название',
        'logo_path' => 'Логотип',
        'description' => 'Описание'
    ];

    public function __construct() {
        $this->idName = 'id_manufacturer';
        $this->tableName = 'manufacturer';
        parent::__construct();
    }

    public function editById(int $id, array $data) {
        echo $data;
        extract($data);
        $sql = "UPDATE `$this->tableName` SET `name`=:name, `description`=:description WHERE `$this->idName`=:id";
        $params = ['name' => $name, 'description' => $description, 'id' => $id];
        $this->sqlExecute($sql, $params);
    }

    public function addNew(array $data) {
        foreach ($data as $item) {
            $item = htmlspecialchars($item);
        }
        extract($data);
        $sql = "INSERT INTO `$this->tableName`(`name`, `logo_path`, `description`) VALUES (:name, :logo_path, :description)";
        $params = ['name' => $name, 'logo_path' => $logo_path, 'description' => $description];
        $this->sqlExecute($sql, $params);
    }

    public function getById(int $id) {
        $sql = "SELECT * FROM `$this->tableName` WHERE `$this->idName`=$id";
        return $this->sqlQuery($sql)[0];
    }
}