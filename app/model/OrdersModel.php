<?php
include_once 'app/core/Model.php';

class OrdersModel extends Model {

    const COLUMN_RUS_ASSOC = [
        'id_order' => 'ID',
        'id_user' => 'Пользователь',
        'date' => 'Дата оформления',
        'completed' => 'Статус',
        'name' => 'Имя'
    ];

    public function __construct() {
        $this->idName = 'id_order';
        $this->tableName = 'orders';
        $this->selects = ['completed' => [[0, 'Завершен'], [1, 'Активен']]];
        parent::__construct();
    }

    public function addOrder(int $userId, string $name) {
        $sql = "INSERT INTO `$this->tableName` (`id_user`, `date`, `name`) VALUES (:userId, CURDATE(), :name)";
        $data = ['userId' => $userId, 'name' => $name];
        $this->sqlExecute($sql, $data);
        return $this::$connection->lastInsertId();
    }

    public function addProductsInOrder(int $orderId, array $productIDs) {
        $VALUES = '';  //value: (id_order, id_product, count)
        for ($i = 0; $i < count($productIDs[0]); $i++) {
            if ($i != 0)
                $VALUES = $VALUES.',';
            $VALUES = $VALUES.'('.$orderId.','.$productIDs[0][$i].','.$productIDs[1][$i].')';
        }
        $sql = "INSERT INTO `order_products`(`id_order`, `id_product`, `count`) VALUES ".$VALUES;
        $this->sqlQuery($sql);
    }

    public function getAll() {
        $sql = "SELECT * FROM `$this->tableName` ORDER BY `date`, `completed` DESC";
        return $this->sqlQuery($sql);
    }

    public function editById(int $id, array $data) {
        foreach ($data as $item) {
            if (is_string($item))
                $item = htmlspecialchars($item);
        }
        extract($data);
        $sql = "UPDATE `$this->tableName` SET `date`=:date, `completed`=:completed, `name`=:name WHERE `$this->idName`=:id";
        $params = ['date' => $date, 'completed' => $completed, 'name' => $name, 'id' => $id];
        $this->sqlExecute($sql, $params);
    }

    public function getOrderProductsById(int $id_order) {
        $sql = "SELECT t1.`$this->idName`, t1.`name`, t2.`phone`, t2.`address` FROM `$this->tableName` t1 INNER JOIN `users` t2 ON t1.`id_user`=t2.`id_user` WHERE t1.`$this->idName`=$id_order";
        $mainData = $this->sqlQuery($sql)[0];
        $sql = "SELECT t1.`id_product`, t2.`picture_path`, t2.`name`, t1.`count`, t2.`cost` FROM `order_products` t1 INNER JOIN `products` t2 ON t1.`id_product`=t2.`id_product` WHERE t1.`id_order`=$id_order";
        $products = $this->sqlQuery($sql);
        $sum = 0;
        foreach ($products as $product) {
            $sum += $this->parseFloat($product['cost'])*(int)$product['count'];
        }
        $mainData['sum'] = $sum.' руб.';
        return ['mainData' => $mainData, 'products' => $products];
    }
}