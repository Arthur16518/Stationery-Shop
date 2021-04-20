<?php
include_once 'app/core/IController.php';
include_once 'app/view/CatalogView.php';
include_once 'app/model/CategoryModel.php';
include_once 'app/model/ProductsModel.php';
include_once 'app/model/CartModel.php';
include_once 'app/model/ManufacturerModel.php';

class CatalogController implements IController {
    private $view;

    public function __construct() {
        $this->view = new CatalogView();
    }

    public function index() {
        if (isset($_GET['id_product'])) {
            $this->productCard();
            return;
        }
        if (isset($_GET['id_manufacturer'])) {
            $this->manufacturerCard();
            return;
        }
        $categoryId = (int)$_GET['id_category'];
        $catModel = new CategoryModel();
        $categories = $catModel->getOrderedCategories();
        $children = $this->searchChildren($categoryId, $categories);
        $products = new ProductsModel();
        if (!isset($_GET['sort'])) {
            $_GET['sort'] = 'up';
            $template = 'catalog';
        } else {
            $template = 'products';
        }

        $products = $products->getAllWithCategories($categoryId, $children, $_GET['sort']);
        $categories = $this->searchCloseChildren($categoryId, $categories);
        $catName = $catModel->getNameById($categoryId);
        $this->view->render($template, ['products' => $products, 'categories' => $categories, 'catName' => $catName]);
    }

    private function productCard() {
        try {
            $product = new ProductsModel();
            $product = $product->getDataForCard((int)$_GET['id_product']);
            $this->view->render('productCard', ['product' => $product]);
        } catch (Exception $ex) {
            echo '1';
        }
    }

    private function manufacturerCard() {
        try {
            $manufacturer = new ManufacturerModel();
            $manufacturer = $manufacturer->getById((int)$_GET['id_manufacturer']);
            $this->view->render('manufacturerCard', ['manufacturer' => $manufacturer]);
        } catch (Exception $ex) {
            echo '1';
        }
    }

    // searches all children: [biggest_category, ... , smallest_category]
    private function searchChildren(int $targetId, array $allCategories, array $result = []) {
        foreach ($allCategories as $item) {
            if ($item['id_category_parent'] == $targetId) {
                array_push($result, $item);
                $result = $this->searchChildren($item['id_category'], $allCategories, $result);
            }
        }
        return $result;
    }

    private function searchCloseChildren(int $targetId, array $allCategories) {
        $result = [];
        foreach ($allCategories as $category) {
            if ($category['id_category_parent'] == $targetId) {
                array_push($result, $category);
            }
        }
        return $result;
    }
}