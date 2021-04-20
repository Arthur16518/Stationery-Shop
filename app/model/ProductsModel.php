<?php
include_once 'app/core/Model.php';

class ProductsModel extends Model {

    const COLUMN_RUS_ASSOC = [
        'id_product' => 'ID',
        'id_category' => 'Категория',
        'id_manufacturer' => 'Производитель',
        'cost' => 'Стоимость',
        'description' => 'Описание',
        'count' => 'Количество',
        'name' => 'Название',
        'picture_path' => 'Картинка'
    ];

    public function __construct() {
        $this->idName = 'id_product';
        $this->tableName = 'products';
        parent::__construct();
    }

    public function editById(int $id, array $data) {
        foreach ($data as $item) {
            if (is_string($item))
                $item = htmlspecialchars($item);
        }
        extract($data);
        $sql = "UPDATE `$this->tableName` SET `name`=:name, `cost`=:cost, `description`=:description, `count`=:count WHERE `$this->idName`=:id";
        $params = ['name' => $name, 'cost' => $cost, 'description' => $description, 'count' => $count, 'id' => $id];
        $this->sqlExecute($sql, $params);
    }

    public function getAll()
    {
        $this->initSelects();
        return parent::getAll();
    }

    public function initSelects() {
        $categorySelects = $this->getCategorySelects();
        $manufacturerSelects = $this->getManufacturerSelects();
        $this->selects = ['id_category' => $categorySelects, 'id_manufacturer' => $manufacturerSelects];
    }

    public function addNew(array $data) {
        foreach ($data as $item) {
            $item = htmlspecialchars($item);
        }
        extract($data);
        $cost = $this->parseFloat($cost);
        $count = (int)$count;
        if ($id_category == 'NULL')
            $id_category = null;
        if ($id_manufacturer == 'NULL')
            $id_manufacturer = null;
        $sql = "INSERT INTO `$this->tableName`(`id_category`, `id_manufacturer`, `cost`, `description`, `count`, `name`, `picture_path`) 
VALUES (:id_category, :id_manufacturer, :cost, :description, :count, :name, :picture_path)";
        $params = [
            'id_category' => $id_category,
            'id_manufacturer' => $id_manufacturer,
            'cost' => $cost,
            'description' => $description,
            'count' => $count,
            'name' => $name,
            'picture_path' => $picture_path
        ];
        $this->sqlExecute($sql, $params);
    }

    public function getAllWithCategories(int $mainId, array $categories, string $sort = 'name-up') {
        $IN = "$mainId";
        foreach ($categories as $category) {
            $IN = $IN.','.$category['id_category'];
        }
        switch ($sort) {
            case 'up':
                $orderSQL = '`name`';
                break;
            case 'down':
                $orderSQL = '`name` DESC';
                break;
            case 'cost-up':
                $orderSQL = '`cost`';
                break;
            case 'cost-down':
                $orderSQL = '`cost` DESC';
                break;
        }
        $sql = "SELECT * FROM `$this->tableName` t1 
                INNER JOIN `category_id_name` t2 ON t1.`id_category` = t2.`id_category` 
                WHERE t1.`id_category` IN ($IN) ORDER BY ".$orderSQL;
        return $this->sqlQuery($sql);
    }

    public function getDataForCard(int $id_product) {
        $sql = "SELECT * FROM `$this->tableName` t1
                INNER JOIN `category_id_name` t2 ON t1.`id_category`=t2.`id_category`
                INNER JOIN `manufacturer_id_name` t3 ON t1.`id_manufacturer`=t3.`id_manufacturer`
                WHERE t1.`id_product`=$id_product";
        return $this->sqlQuery($sql)[0];
    }

    public function getProductsWithIDs(array $IDs) {
        $IN = $this->buildINStr($IDs);
        $sql = "SELECT `name`, `cost`, `picture_path`, `$this->idName`, `count` FROM `$this->tableName` WHERE `$this->idName` IN ".$IN;
        return $this->sqlQuery($sql);
    }

    public function search(string $searchQuery) {
        $sql = "SELECT * FROM `products` WHERE LOCATE(:searchQuery, `name`)<>0";
        $data = ['searchQuery' => htmlspecialchars($searchQuery)];
        return $this->sqlExecute($sql, $data);
    }

    private function getCategorySelects() {
        $sql = "SELECT `id_category`, `name` FROM `category`";
        return $this->sqlQuery($sql);
    }

    private function getManufacturerSelects() {
        $sql = "SELECT `id_manufacturer`, `name` FROM `manufacturer`";
        return $this->sqlQuery($sql);
    }
}