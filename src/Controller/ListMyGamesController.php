<?php

namespace App\Controller;

use App\Model\ListMyGamesManager;
use App\Model\UserConnectionModel;

class ListMyGamesController extends AbstractController
{
    public function index()
    {
        $listMyGamesManager = new ListMyGamesManager();
        $selectUserByNickname = $listMyGamesManager->selectByUserNickname();
        return $this->twig->render(
            'ListMyGames/index.html.twig',
            ['selectUserByNickname' => $selectUserByNickname]
        );
    }
}
