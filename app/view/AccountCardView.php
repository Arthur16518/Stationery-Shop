<?php
include_once 'app/core/View.php';

class AccountCardView extends View {
    public function render(string $template, array $data) {
        extract($data);
        include_once $this::TEMPLATES_PATH.$template.'.php';
    }

    public function returnTemplate(string $template) {
        include_once $this::TEMPLATES_PATH.$template.'.php';
    }
}