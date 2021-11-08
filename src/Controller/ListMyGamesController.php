<?php

namespace App\Controller;

use App\Model\ListMyGamesManager;

class ListMyGamesController extends AbstractController
{
    public function index(int $id)
    {
        $gameManager = new ListMyGamesManager();
        $userId = $gameManager->selectByUserId($id);
        $allFromGamesByUserId = $gameManager->selectAllFromGameOnListUser($id);
        return $this->twig->render(
            'ListMyGames/index.html.twig',
            ['userId' => $userId, 'allFromGamesByUserId' => $allFromGamesByUserId]
        );
    }
}
