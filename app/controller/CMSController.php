<?php
include_once 'app/core/IController.php';
include_once 'app/view/CMSView.php';
include_once 'app/model/UsersModel.php';
include_once 'app/model/AdminsModel.php';
include_once 'app/model/NewsModel.php';
include_once 'app/model/ProductsModel.php';
include_once 'app/model/ManufacturerModel.php';
include_once 'app/model/CategoryModel.php';
include_once 'app/controller/HomeController.php';
include_once 'app/model/OrdersModel.php';

class CMSController implements IController {
    private $view;

    const DATA_ASSOC = [
        'ЛЕНТА' => 'news',
        'ТОВАРЫ' => 'products',
        'КАТЕГОРИИ' => 'category',
        'ПОЛЬЗОВАТЕЛИ' => 'users',
        'ПРОИЗВОДИТЕЛИ' => 'manufacturer',
        'АДМИНИСТРАТОРЫ' => 'admins',
        'ЗАКАЗЫ' => 'orders'
    ];
    const PICTURES_PATH = 'resources/pictures';

    public function __construct()
    {
        if (isset($_SESSION['adminId']))
            $this->view = new CMSView();
        else
            return new HomeController();
    }

    public function index()
    {
        session_start();
        if (isset($_GET['data'])) {
            $this->getData($_GET['data']);
        } elseif (isset($_GET['recordAction'])) {
            $this->editRecord();
        } elseif (isset($_GET['cmsAction'])){
            switch ($_GET['cmsAction']) {
                case 'loadPicture':
                    $this->loadPicture();
                    break;
                case 'getForm':
                    $this->getForm();
                    break;
                case 'addRecord':
                    $this->addRecord();
                    break;
                case 'getOrderProducts':
                    $this->getOrderProducts();
                    break;
            }
        } elseif (isset($_SESSION['adminId'])) {
            return $this->view->render('cms', [null]);
        } else {
            header('Location: index.php');
        }
    }

    private function getOrderProducts() {
        $id_order = (int)$_GET['id_order'];
        $orderProducts = new OrdersModel();
        $orderProducts = $orderProducts->getOrderProductsById($id_order);
        $this->view->render('orderProducts', $orderProducts);
    }

    private function getData(string $table){
        $model = $this->modelByTableName(self::DATA_ASSOC[$table]);
        $data = $model->getAll();
        $keys = array_keys($data[0]);
        $this->view->render('table', ['tableName' => $table, 'data' => $data, 'keys' => $keys, 'rucolumns' => $model::COLUMN_RUS_ASSOC, 'selects' => $model->selects]);
    }

    private function editRecord() {
        try {
            switch ($_GET['recordAction']) {
                case 'delete':
                    $model = $this->modelByTableName($_POST['table']);
                    $model->deleteById((int)$_POST['id']);
                    echo '0';
                    break;
                case 'edit':
                    $model = $this->modelByTableName($_POST['table']);
                    $model->editById((int)$_POST['id'], $_POST);
                    echo '0';
                    break;
            }
        } catch (Exception $ex) {
            echo '1';
        }
    }

    private function loadPicture() {
        ini_set('upload_max_filesize', '10M');
        try {
            $fullPath = $this->createAndMovePicture($_FILES['newPicture']);
            $model = $this->modelByTableName($_POST['table']);
            $model->updateFieldById((int)$_POST['id'], htmlspecialchars($_POST['field']), $fullPath);
            echo $fullPath;
        } catch (Exception $ex) {
            echo '1';
        }
    }

    private function addRecord() {
        ini_set('upload_max_filesize', '10M');
        try {
            if (isset($_FILES)) {
                foreach ($_FILES as $key=>$file) {
                    $filePath = $this->createAndMovePicture($file);
                    $_POST[$key] = $filePath;
                }
            }
            $model = $this->modelByTableName($_POST['table']);
            $model->addNew($_POST);
            echo '0';
        } catch (Exception $ex) {
            echo '1';
        }
    }

    private function createAndMovePicture($filesItem) {
        $fileExtension = strtolower(explode('.', $filesItem['name'])[1]);
        $newFileName = $this::generateFileName($filesItem['name']) . '.' . $fileExtension;
        $fullPath = $this::PICTURES_PATH . '/' . $newFileName;
        move_uploaded_file($filesItem['tmp_name'], $fullPath);
        return $fullPath;
    }

    private function getForm() {
        try {
            $model = $this->modelByTableName($_GET['table']);
            $model->initSelects();
            $this->view->render('addRecordForm', ['fields' => $model::COLUMN_RUS_ASSOC, 'table' => $_GET['table'], 'selects' => $model->selects]);
        } catch (Exception $ex) {
            echo '1';
        }
    }

    private function modelByTableName(string $tableName) {
        switch ($tableName) {
            case 'news':
                $model = new NewsModel();
                break;
            case 'products':
                $model = new ProductsModel();
                break;
            case 'feedback':
                break;
            case 'category':
                $model = new CategoryModel();
                break;
            case 'users':
                $model = new UsersModel();
                break;
            case 'manufacturer':
                $model = new ManufacturerModel();
                break;
            case 'admins':
                $model = new AdminsModel();
                break;
            case 'orders':
                $model = new OrdersModel();
                break;
        }
        return $model;
    }

    private function generateFileName(string $originalName) {
        $date = new DateTime();
        return md5($date->format('r').$originalName);
    }
}