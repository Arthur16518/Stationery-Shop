<?php
include_once 'app/core/Model.php';

class NewsModel extends Model
{
    const COLUMN_RUS_ASSOC = [
        'id_news' => 'ID',
        'content_path' => 'Картинка',
        'link' => 'Ссылка',
        'order_num' => 'Порядок'
    ];

    public function __construct() {
        $this->idName = 'id_news';
        $this->tableName = 'news';
        parent::__construct();
    }

    public function editById(int $id, array $data) {
        foreach ($data as $item) {
            $item = htmlspecialchars($item);
        }
        extract($data);
        $sql = "UPDATE `$this->tableName` SET `link`=:link, `order_num`=:order_num WHERE `$this->idName`=:id";
        $params = ['link' => $link, 'order_num' => $order_num, 'id' => $id];
        $this->sqlExecute($sql, $params);
    }

    public function addNew(array $data) {
        foreach ($data as $item) {
            $item = htmlspecialchars($item);
        }
        extract($data);
        $order_num = (int)$order_num;
        $sql = "INSERT INTO `$this->tableName`(`content_path`, `link`, `order_num`) VALUES (:content_path, :link, :order_num)";
        $params = ['content_path' => $content_path, 'link' => $link, 'order_num' => $order_num];
        $this->sqlExecute($sql, $params);
    }

    public function getOrderedPics() {
        $sql = "SELECT `order_num`, `content_path`, `link` FROM `$this->tableName` ORDER BY `order_num`";
        return $this->sqlQuery($sql);
    }
}