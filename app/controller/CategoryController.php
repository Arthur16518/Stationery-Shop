<?php
include_once 'app/core/IController.php';
include_once 'app/view/CategoryView.php';
include_once 'app/model/CategoryModel.php';

class CategoryController implements IController {
    private $view;

    public function __construct() {
        $this->view = new CategoryView();
    }

    public function index() {
        $categories = new CategoryModel();
        $categories = $categories->getOrderedCategories();
        $bigCategories = [];
        $smallCategories = [];
        foreach ($categories as $item) {
            if ($item['id_category_parent'] == null)
                array_push($bigCategories, $item);
            else
                array_push($smallCategories, $item);
        }
        $this->view->render('categories', ['bigCategories' => $bigCategories, 'smallCategories' => $smallCategories]);
    }
}