<?php

namespace App\Controllers;

class BaseController {
    protected function render($view, $data = []) {
        extract($data);
        
        $viewPath = "../app/Views/" . $view . ".php";
        
        if (file_exists($viewPath)) {
            ob_start();
            require $viewPath;
            $content = ob_get_clean();
            require "../app/Views/layouts/main.php";
        } else {
            throw new \Exception("Vue non trouvée : " . $view);
        }
    }

    protected function redirect($url) {
        header("Location: " . $url);
        exit();
    }

    protected function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
}