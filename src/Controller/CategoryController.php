<?php

namespace App\Controller;

use App\Model\GameCategoryManager;

class CategoryController extends AbstractController
{
    public function index(int $id)
    {
        $gameManager = new GameCategoryManager();
        $genres = $gameManager->selectOneByGenreId($id);
        return $this->twig->render('category/index.html.twig', ['genres' => $genres]);
    }
}
