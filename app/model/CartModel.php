<?php
include_once 'app/core/Model.php';

class CartModel extends Model {

    public function __construct()
    {
        $this->idName = null;
        $this->tableName = 'cart';
        parent::__construct();
    }

    // returns [id_products] in cart for user
    public function getByUserId(int $userId) {
        $sql = "SELECT `id_product` FROM `$this->tableName` WHERE `id_user`=$userId";
        $userCart = $this->sqlQuery($sql);
        $result = [];
        foreach ($userCart as $item) {
            array_push($result, $item['id_product']);
        }
        return $result;
    }

    public function count(int $userId) {
        $sql = "SELECT count(*) total FROM `$this->tableName` WHERE `id_user` = $userId";
        return $this->sqlQuery($sql)[0]['total'];
    }

    public function addToCart(int $userId, int $productId) {
        $sql = "INSERT INTO `$this->tableName`(`id_user`, `id_product`) VALUES (:userId, :productId)";
        $data = ['userId' => $userId, 'productId' => $productId];
        $this->sqlExecute($sql, $data);
    }

    public function dropProducts(int $userId, array $productIDs) {
        $IN = $this->buildINStr($productIDs);
        $sql = "DELETE FROM `$this->tableName` WHERE `id_user`=$userId AND `id_product` IN ".$IN;
        $this->sqlQuery($sql);
    }
}