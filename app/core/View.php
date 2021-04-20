<?php

class View {
    const TEMPLATES_PATH = 'templates/';

    public function render(string $template, array $data) {
        extract($data);
        include_once $this::TEMPLATES_PATH.'main.php';
    }
}