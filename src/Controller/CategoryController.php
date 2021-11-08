<?php

namespace App\Controller;

use App\Model\CategoryManager;

class CategoryController extends AbstractController
{
    public function index(int $id)
    {
        $gameManager = new CategoryManager();
        $category = $gameManager->selectByGenre($id);
        $gameInfos = $gameManager->selectAllGamesFromCategoryId($id);
        // $categoriesId = $gameManager->selectgameByID($id);
        // foreach ($categoriesId as $categorieId) {
        //     $namesGameById[] = $gameManager->selectCategoriesByNameIdTag($categorieId['game_id']);
        //     foreach ($namesGameById as $gameById);
        // }
        return $this->twig->render('Category/index.html.twig', ['category' => $category, 'gameInfos' => $gameInfos]);
    }
}
