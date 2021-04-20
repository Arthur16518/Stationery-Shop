<?php
include_once 'app/core/Model.php';

class AdminsModel extends Model {

    const COLUMN_RUS_ASSOC = [
        'id_admin' => 'ID',
        'login' => 'Логин',
        'password' => 'Пароль',
        'email' => 'Email',
    ];

    public function __construct() {
        $this->idName = 'id_admin';
        $this->tableName = 'admins';
        parent::__construct();
    }

    public function getByLogin(string $login) {
        $login = htmlspecialchars($login);
        $sql = "SELECT * FROM `$this->tableName` WHERE `login` = :login OR `email` = :login";
        $params = ['login' => $login];
        return $this->sqlExecute($sql, $params)[0];
    }

    public function editById(int $id, array $data) {
        echo $data;
        extract($data);
        $sql = "UPDATE `$this->tableName` SET `login`=:login, `email`=:email WHERE `$this->idName`=:id";
        $params = ['login' => $login, 'email' => $email, 'id' => $id];
        $this->sqlExecute($sql, $params);
    }

    public function addNew(array $data) {
        foreach ($data as $item) {
            $item = htmlspecialchars($item);
        }
        extract($data);
        $sql = "INSERT INTO `$this->tableName`(`login`, `password`, `email`) VALUES (:login, :password, :email)";
        $params = ['login' => $login, 'password' => $password, 'email' => $email];
        $this->sqlExecute($sql, $params);
    }

    public function changePassword(string $email, string $newPassword) {
        $sql = "UPDATE `$this->tableName` SET `password`=:password WHERE `email`=:email";
        $data = ['password' => $newPassword, 'email' => $email];
        $this->sqlExecute($sql, $data);
    }
}