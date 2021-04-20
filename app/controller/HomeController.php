<?php
include_once 'app/core/IController.php';
include_once 'app/view/HomeView.php';
include_once 'app/model/NewsModel.php';

class HomeController implements IController {
    private $view;

    public function __construct() {
        $this->view = new HomeView();
    }

    public function index() {
        $news = new NewsModel();
        $news = $news->getOrderedPics();
        return $this->view->render('home', ['pictures' => $news]);
    }
}