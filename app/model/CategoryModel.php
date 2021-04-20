<?php
include_once 'app/core/Model.php';

class CategoryModel extends Model
{
    const COLUMN_RUS_ASSOC = [
        'id_category' => 'ID',
        'name' => 'Название',
        'id_category_parent' => 'Родительская категория',
    ];

    public function __construct() {
        $this->idName = 'id_category';
        $this->tableName = 'category';
        parent::__construct();
    }

    public function editById(int $id, array $data) {
        echo $data;
        extract($data);
        if ($id_category_parent == 'NULL')
            $id_category_parent = null;
        $sql = "UPDATE `$this->tableName` SET `name`=:name, `id_category_parent`=:id_category_parent WHERE `$this->idName`=:id";
        $params = ['name' => $name, 'id_category_parent' => $id_category_parent, 'id' => $id];
        $this->sqlExecute($sql, $params);
    }

    public function getAll()
    {
        $this->initSelects();
        return parent::getAll();
    }

    public function addNew(array $data) {
        foreach ($data as $item) {
            $item = htmlspecialchars($item);
        }
        extract($data);
        if ($id_category_parent == 'NULL')
            $id_category_parent = null;
        $sql = "INSERT INTO `$this->tableName`(`name`, `id_category_parent`) VALUES (:name, :id_category_parent)";
        $params = ['name' => $name, 'id_category_parent' => $id_category_parent];
        $this->sqlExecute($sql, $params);
    }

    public function initSelects() {
        $idWithNames = $this->getIdWithNames();
        $this->selects = ['id_category_parent' => $idWithNames];
    }

    private function getIdWithNames() {
        $sql = "SELECT `$this->idName`, `name` FROM `$this->tableName`";
        return $this->sqlQuery($sql);
    }

    public function getOrderedCategories() {
        $sql = "SELECT * FROM `category` ORDER BY `id_category_parent`";
        return $this->sqlQuery($sql);
    }

    public function getNameById(int $id) {
        $sql = "SELECT `name` FROM `$this->tableName` WHERE `$this->idName`=$id";
        return $this->sqlQuery($sql)[0]['name'];
    }
}