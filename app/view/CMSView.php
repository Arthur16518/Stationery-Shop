<?php
include_once 'app/core/View.php';

class CMSView extends View {
    const IMAGE_REQUIRED = [
        'content_path', 'logo_path', 'picture_path'
    ];
    const TEXTAREA_REQUIRED = [
        'description'
    ];
    const SELECT_REQUIRED = [
        'category' => ['id_category_parent'],
        'products' => ['id_category', 'id_manufacturer'],
        'manufacturer' => [],
        'admins' => [],
        'users' => [],
        'news' => [],
        'orders' => ['completed']
    ];
    const ADD_REQUIRED = [
        'admins', 'category', 'manufacturer', 'news', 'products'
    ];

    public function render(string $template, array $data) {
        extract($data);
        include_once $this::TEMPLATES_PATH.$template.'.php';
    }
}