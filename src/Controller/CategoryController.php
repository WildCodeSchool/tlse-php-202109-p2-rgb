<?php

namespace App\Controller;

use App\Model\CategoryManager;

class CategoryController extends AbstractController
{
    public function index(int $id)
    {
        $gameManager = new CategoryManager();
        $genre = $gameManager->selectByGenre($id);
        $gameInfos = $gameManager->selectAllGamesFromCategoryId($id);
        return $this->twig->render('Category/index.html.twig', ['genre' => $genre, 'gameInfos' => $gameInfos]);
    }
}
