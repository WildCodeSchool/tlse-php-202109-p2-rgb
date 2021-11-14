<?php

namespace App\Controller;

use App\Model\ListMyGamesManager;
use App\Model\DescriptionGameModel;
use App\Model\UserConnectionModel;

class ListMyGamesController extends AbstractController
{
    public function index()
    {
        $listGameManager = new ListMyGamesManager();
        $descriptionGame = new DescriptionGameModel();
        $userId = $descriptionGame->getUserId();
        $gameByUserId = $listGameManager->getAllFromListUser($userId);
        return $this->twig->render(
            'ListMyGames/index.html.twig',
            ['gamesByUser' => $gameByUserId]
        );
    }
}
