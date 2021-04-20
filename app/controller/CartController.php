<?php
include_once 'app/core/IController.php';
include_once 'app/model/CartModel.php';
include_once 'app/view/CartView.php';
include_once 'app/model/ProductsModel.php';
include_once 'app/model/UsersModel.php';
include_once 'app/model/OrdersModel.php';
include_once 'app/libs/PHPMailer.php';

class CartController implements IController {
    private $view;
    private $userId;

    public function __construct() {
        $this->view = new CartView;
        $this->userId = (int)$_SESSION['userId'];
    }

    public function index() {
        if (isset($_GET['cartAction'])) {
            switch ($_GET['cartAction']) {
                case 'addToCart':
                    $this->addToCart();
                    break;
                case 'count':
                    $this->count();
                    break;
                case 'remove':
                    $this->remove();
                    break;
            }
        } else {
            $products = null;
            if (count($_SESSION['cart']) > 0) {
                $products = new ProductsModel();
                $products = $products->getProductsWithIDs($_SESSION['cart']);
            }
            $user = new UsersModel();
            $user = $user->getById($this->userId);
            $this->view->render('cart', ['products' => $products, 'user' => $user]);
        }
    }

    private function addToCart() {
        try {
            $model = new CartModel();
            $model->addToCart($this->userId, (int)$_GET['id_product']);
            $_SESSION['cart'] = $model->getByUserId($this->userId);
            echo count($_SESSION['cart']);
        } catch (Exception $ex) {
            echo '-1';
        }
    }

    //$_SESSION['cart'] contains strings

    public function newOrder() {
        if (isset($_SESSION['userId'])){
            try {
                $model = new OrdersModel();
                $orderId = $model->addOrder($this->userId, $_POST['name']);
                $productsData = json_decode($_POST['productsData']);
                $model->addProductsInOrder($orderId, $productsData);
                $model = new CartModel();
                $model->dropProducts($this->userId, $productsData[0]);
                $_SESSION['cart'] = $model->getByUserId($this->userId);
                $model = new UsersModel();
                $model->updateUserByOrderData($this->userId, $_POST['phone'], $_POST['address']);
                $this->sendOrderId($model->getById($this->userId)['email'], $orderId);
                echo '0';
            } catch (Exception $ex) {
                echo '1';
            }
        } else {
            echo '1';
        }
    }

    private function count() {
        echo count($_SESSION['cart']);
    }

    private function remove() {
        try {
            $model = new CartModel();
            $model->dropProducts($this->userId, [(int)$_GET['id_product']]);
            $_SESSION = $model->getByUserId($this->userId);
            echo '0';
        } catch (Exception $ex) {
            echo '1';
        }
    }

    private function sendOrderId(string $email, $orderId) {
        $mailer = new PHPMailer\PHPMailer\PHPMailer();
        $mailer->Host = 'smtp.gmail.com';
        $mailer->isSMTP();
        $mailer->SMTPAuth = true;
        $mailer->SMTPSecure = 'tls';
        $mailer->Port = 587;
        $mailer->CharSet = 'UTF-8';
        $mailer->Username = 'officesupplyshop1@gmail.com';
        $mailer->Password = '|)eVel0per';
        $mailer->setFrom($mailer->Username);
        $mailer->addAddress($email);
        $mailer->isHTML(true);
        $mailer->Subject = 'Ваш заказ оформлен!';
        $message = "<p>Номер вашего заказа: <b>$orderId</b></p>";
        $mailer->Body = $message;
        $mailer->send();
    }
}