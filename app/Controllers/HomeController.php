<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index()
    {
        // Charger la vue de la page d'accueil
        require __DIR__ . '/../Views/home/index.php';
    }
}