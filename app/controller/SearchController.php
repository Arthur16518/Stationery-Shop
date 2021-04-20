<?php
include_once 'app/core/IController.php';
include_once 'app/view/SearchView.php';
include_once 'app/model/ProductsModel.php';

class SearchController implements IController {
    private $view;

    public function __construct() {
        $this->view = new SearchView();
    }

    public function index() {
        $products = new ProductsModel();
        $products = $products->search($_GET['query']);
        $this->view->render('searchResult', ['searchQuery' => $_GET['query'],'products' => $products]);
    }
}