<?php

namespace App\Controller;

use App\Model\CategoryManager;
use App\Model\UserConnectionModel;

class CategoryController extends AbstractController
{
    public function index(int $id)
    {
        $gameManager = new CategoryManager();
        $category = $gameManager->selectByGenre($id);
        $gameInfos = $gameManager->selectAllGamesFromCategoryId($id);
        return $this->twig->render(
            'Category/index.html.twig',
            [
                'category' => $category,
                'gameInfos' => $gameInfos,
            ]
        );
    }
}
