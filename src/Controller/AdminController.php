<?php

namespace App\Controller;

use App\Model\AdminModel;

class AdminController extends AbstractController
{
    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $addGamesOnDatabase = new AdminModel();
            $addGamesOnDatabase->addGameOnDatabase($_POST);
            $addGamesOnDatabase->addGameCategories($_POST);
        }
        return $this->twig->render(
            'Home/admin.html.twig',
        );
    }
}
