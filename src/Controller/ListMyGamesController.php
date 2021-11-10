<?php

namespace App\Controller;

use App\Model\ListMyGamesManager;
use App\Model\UserConnectionModel;

class ListMyGamesController extends AbstractController
{
    public function index()
    {
        $gameManager = new ListMyGamesManager();
        $userId = $gameManager->selectByUserId();
        return $this->twig->render('ListMyGames/index.html.twig', ['userId' => $userId,]);
    }
}
