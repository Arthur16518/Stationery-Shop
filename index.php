<?php
include_once 'app/controller/HomeController.php';
include_once 'app/controller/AccController.php';
include_once 'app/controller/CMSController.php';
include_once 'app/controller/CategoryController.php';
include_once 'app/controller/CatalogController.php';
include_once 'app/controller/CartController.php';
include_once 'app/controller/SearchController.php';

error_reporting(E_ALL & ~E_NOTICE);
session_save_path(__DIR__.'/sessions');
session_start();

if (!isset($_GET['action']))
    $_GET['action'] = 'home';
switchStart: switch ($_GET['action']){
    case 'signIn':
        $acc = new AccController();
        $acc->signIn();
        break;
    case 'signUp':
        $acc = new AccController();
        $acc->signUp();
        break;
    case 'checkUniqueness':
        $acc = new AccController();
        $acc->checkUniqueness();
        break;
    case 'adminSignIn':
        $acc = new AccController();
        $acc->adminSignIn();
        break;
    case 'cms':
        $cms = new CMSController();
        $cms->index();
        break;
    case 'checkAdminLogin':
        $acc = new AccController();
        $acc->checkAdminLogin();
        break;
    case 'resetPassword':
        $acc = new AccController();
        $acc->resetPassword();
        break;
    case 'categories':
        $cat = new CategoryController();
        $cat->index();
        break;
    case 'catalog':
        $catalog = new CatalogController();
        $catalog->index();
        break;
    case 'cart':
        $cart = new CartController();
        $cart->index();
        break;
    case 'newOrder':
        $cart = new CartController();
        $cart->newOrder();
        break;
    case 'accountCard':
        $acc = new AccController();
        $acc->accountCard();
        break;
    case 'search':
        $search = new SearchController();
        $search->index();
        break;
    case 'sessionDestroy':
        session_destroy();
        header('Location: index.php');
        break;
    default:
        if (isset($_SESSION['adminId'])){
            $_GET['action'] = 'cms';
            goto switchStart;
        }
        $home = new HomeController();
        $home->index();
        break;
}