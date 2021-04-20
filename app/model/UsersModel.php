<?php
include_once 'app/core/Model.php';

class UsersModel extends Model {

    const COLUMN_RUS_ASSOC = [
        'id_user' => 'ID',
        'login' => 'Логин',
        'password' => 'Пароль',
        'email' => 'Email',
        'address' => 'Адрес',
        'phone' => 'Телефон'
    ];

    public function __construct() {
        $this->idName = 'id_user';
        $this->tableName = 'users';
        parent::__construct();
    }

    public function getByLogin(string $login) {
        $login = htmlspecialchars($login);
        $sql = "SELECT * FROM `$this->tableName` WHERE `login` = :login OR `email` = :login";
        $params = ['login' => $login];
        return $this->sqlExecute($sql, $params)[0];
    }

    public function addNew(array $params) {
        foreach ($params as $item) {
            $item = htmlspecialchars($item);
        }
        $sql = "INSERT INTO `users`(`login`, `password`, `email`, `address`, `phone`) VALUES (:login, :password, :email, :address, :phone)";
        $this->sqlExecute($sql, $params);
    }

    public function editById(int $id, array $data) {
        echo $data;
        extract($data);
        $sql = "UPDATE `$this->tableName` SET `login`=:login, `email`=:email, `address`=:address, `phone`=:phone WHERE `$this->idName`=:id";
        $params = ['login' => $login, 'email' => $email, 'address' => $address, 'phone' => $phone, 'id' => $id];
        $this->sqlExecute($sql, $params);
    }

    public function changePassword(string $email, string $newPassword) {
        $sql = "UPDATE `$this->tableName` SET `password`=:password WHERE `email`=:email";
        $data = ['password' => md5($newPassword), 'email' => $email];
        $this->sqlExecute($sql, $data);
    }

    public function getById(int $id) {
        $sql = "SELECT * FROM `$this->tableName` WHERE `$this->idName`=$id";
        return $this->sqlQuery($sql)[0];
    }

    public function updateUserByOrderData(int $userId, string $phone, string $address) {
        $sql = "UPDATE `$this->tableName` SET `phone`=:phone, `address`=:address WHERE `$this->idName`=:userId";
        $data = ['phone' => $phone, 'address' => $address, 'userId' => $userId];
        $this->sqlExecute($sql, $data);
    }
}