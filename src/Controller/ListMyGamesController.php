<?php

namespace App\Controller;

use App\Model\ListMyGamesManager;

class ListMyGamesController extends AbstractController
{
    public function index(int $id)
    {
        $gameManager = new ListMyGamesManager();
        $userId = $gameManager->selectByUserId($id);
        return $this->twig->render('ListMyGames/index.html.twig', ['userId' => $userId,]);
    }
}
