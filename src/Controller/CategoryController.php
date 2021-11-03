<?php

namespace App\Controller;

use App\Model\GameCategoryManager;

class CategoryController extends AbstractController 
{
    public function index(int $id) 
    {
        $gameManager = new GameCategoryManager();
        $genre = $gameManager->selectByGenre($id);
        $gameInfos = $gameManager->selectInfoFromGame($id);
        
        return $this->twig->render('category/index.html.twig', ['genre' => $genre, 'gameInfos' => $gameInfos]);
    }

}
