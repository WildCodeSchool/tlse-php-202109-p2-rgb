<?php

namespace App\Controller;

use App\Model\CategoryManager;

class CategoryController extends AbstractController
{
    public function index(int $id, ?int $gameId = null)
    {
        if (isset($gameId)) {
        }
        $gameManager = new CategoryManager();
        $category = $gameManager->selectByGenre($id);
        $gameInfos = $gameManager->selectAllGamesFromCategoryId($id);
        return $this->twig->render(
            'Category/index.html.twig',
            ['category' => $category, 'gameInfos' => $gameInfos]
        );
    }
}
