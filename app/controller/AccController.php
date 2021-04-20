<?php
include_once 'app/core/IController.php';
include_once 'app/model/UsersModel.php';
include_once 'app/model/AdminsModel.php';
include_once 'app/libs/PHPMailer.php';
include_once 'app/model/CartModel.php';
include_once 'app/view/AccountCardView.php';

class AccController implements IController {
    private $cardView;

    public function __construct() {
        $this->cardView = new AccountCardView();
    }

    public function index() { }

    public function signIn() {
        if (isset($_SESSION['userId']))
            return;
        $user = new UsersModel();
        $user = $user->getByLogin($_POST['login']);
        if ( ($user['password'] == $_POST['password']) || ($user['password'] == md5($_POST['password'])) ) {
            $_SESSION['userId'] = $user['id_user'];
            $cart = new CartModel();
            $cart = $cart->getByUserId((int)$user['id_user']);
            $_SESSION['cart'] = $cart;
            echo '0';
        }
        else
            echo '1';
    }

    public function signUp() {
        $userData = ['login' => $_POST['login'], 'password' => md5($_POST['password']), 'email' => $_POST['email'], 'address' => '', 'phone' => $_POST['phone']];
        $newUser = new UsersModel();
        try {
            $newUser->addNew($userData);
            $newUser = $newUser->getByLogin($_POST['login']);
            $_SESSION['userId'] = $newUser['id_user'];
            echo '0';
        }
        catch (Exception $exception) {
            echo '1';
        }
    }

    public function adminSignIn() {
        session_start();
        if (isset($_SESSION['adminId']))
            return;
        $admin = new AdminsModel();
        $admin = $admin->getByLogin($_POST['login']);
        if ($admin['password'] == $_POST['password'] || $admin['password'] == md5($_POST['password'])) {
            $_SESSION['adminId'] = $admin['id_admin'];
            echo '0';
        }
        else
            echo '1';
    }

    public function checkUniqueness(){
        $userWithLogin = new UsersModel();
        $userWithLogin = $userWithLogin->getByLogin($_GET['login']);
        if (isset($userWithLogin) && count($userWithLogin) > 0)
            echo '1';
        else
            echo '0';
    }

    public function checkAdminLogin(){
        $adminWithLogin = new AdminsModel();
        $adminWithLogin = $adminWithLogin->getByLogin($_GET['login']);
        if (isset($adminWithLogin) && count($adminWithLogin) > 0)
            echo '1';
        else
            echo '0';
    }

    public function resetPassword() {
        if ($_POST['whoReset'] == 'admin')
            $model = new AdminsModel();
        else
            $model = new UsersModel();
        try {
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
            $mailer->addAddress($_POST['email']);
            $mailer->isHTML(true);
            $mailer->Subject = 'Новый пароль от учетной записи';
            $newPassword = $this->generatePassword();
            $message = "
                <p>Ваш новый пароль от учетной записи: <b>$newPassword</b></p>
                <p><i>Поменять пароль можно в личном кабинете на сайте или на странице администратора</i></p>
            ";
            $mailer->Body = $message;
            if ($mailer->send()) {
                $model->changePassword($_POST['email'], $newPassword);
                echo '0';
            }
        } catch (Exception $ex) {
            echo '1';
        }
    }

    public function accountCard() {
        if (isset($_GET['accountCardAction']) && isset($_SESSION['userId'])) {
            switch ($_GET['accountCardAction']){
                case 'change':
                    $this->editUserField();
                    break;
                case 'passwordCard':
                    $this->passwordCard();
                    break;
                case 'changePassword':
                    $this->changePassword();
                    break;
            }
        }
        elseif (isset($_SESSION['userId'])) {
            $user = new UsersModel();
            $user = $user->getById((int)$_SESSION['userId']);
            $this->cardView->render('accountCard', $user);
        } else {
            echo '1';
        }
    }

    private function changePassword() {
        try {
            $userModel = new UsersModel();
            $user = $userModel->getById((int)$_SESSION['userId']);
            if (md5($_POST['password1']) == $user['password'] || $_POST['password1'] == $user['password']) {
                $userModel->updateFieldById((int)$_SESSION['userId'], 'password', md5($_POST['password2']));
                $this->sendNotification($user['email'], $user['login']);
            } else {
                echo '1';
            }
        } catch (Exception $ex) {
            echo '1';
        }
    }

    private function sendNotification(string $email, string $login) {
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
        $mailer->Subject = 'Изменение пароля от учетной записи';
        $message = "<p>Пароль от вашей учетной записи <b>$login</b> был изменен</p>";
        $mailer->Body = $message;
        $mailer->send();
    }

    private function passwordCard() {
        $this->cardView->returnTemplate('changePassword');
    }

    private function editUserField() {
        try {
            $user = new UsersModel();
            $user->updateFieldById((int)$_SESSION['userId'], $_POST['field'], $_POST['value']);
            echo '0';
        } catch (Exception $ex) {
            echo '1';
        }
    }

    private function generatePassword() {
        $charSet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $result = '';
        for ($i = 0; $i < 8; $i++) {
            $result = $result.$charSet[random_int(0, strlen($charSet)-1)];
        }
        return $result;
    }
}