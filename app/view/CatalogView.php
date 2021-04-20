<?php
include_once 'app/core/View.php';

class CatalogView extends View {
    public function render(string $template, array $data) {
        if ($template != 'catalog') {
            extract($data);
            include_once $this::TEMPLATES_PATH.$template.'.php';
        }
        else
            parent::render($template, $data);
    }
}