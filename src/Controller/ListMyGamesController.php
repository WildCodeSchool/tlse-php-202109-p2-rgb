<?php

namespace App\Controller;

use App\Model\ListMyGamesManager;
use App\Model\UserConnectionModel;

class ListMyGamesController extends AbstractController
{
    public function index(string $nickname)
    {
        $listMyGamesManager = new ListMyGamesManager();
        $selectUserByNickname = $listMyGamesManager->selectByUserNickname($nickname);
        return $this->twig->render(
            'ListMyGames/index.html.twig',
            ['selectUserByNickname' => $selectUserByNickname]
        );
    }
}
