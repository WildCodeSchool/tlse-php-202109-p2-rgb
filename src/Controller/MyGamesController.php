<?php

namespace App\Controller;

use App\Model\MyGamesManager;

class MyGamesController extends AbstractController
{
    public function index(int $id)
    {
        $gameManager = new MyGamesManager();
        $userId = $gameManager->selectByUserId($id);
        return $this->twig->render('myGames/index.html.twig', ['userId' => $userId]);
    }
}
