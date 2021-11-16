<?php

namespace App\Controller;

use App\Model\ListMyGamesManager;
use App\Model\DescriptionGameModel;
use App\Model\SearchManager;
use App\Model\UserConnectionModel;

class ListMyGamesController extends AbstractController
{
    public function index()
    {
        $listGameManager = new ListMyGamesManager();
        $descriptionGame = new DescriptionGameModel();
        $search = new SearchManager();
        $path = $_SERVER['PATH_INFO'] . "?=" . $_SESSION['username'];
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_GET['tags'])) {
                $gameByTags = $search->searchByTag($_GET['tags']);
                return $this->twig->render(
                    'ListMyGames/index.html.twig',
                    ['gamesByUser' => $gameByTags,
                    "path" => $path,]
                );
            } else {
                $userId = $descriptionGame->getUserId();
                $gameByUserId = $listGameManager->getAllFromListUser($userId);
                return $this->twig->render(
                    'ListMyGames/index.html.twig',
                    ['gamesByUser' => $gameByUserId,
                    "path" => $path,]
                );
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $search->selectByTitleGame($_POST['search']);
            return $this->twig->render(
                'ListMyGames/index.html.twig',
                ['gamesByUser' => $result,
                "path" => $path,]
            );
        }
    }
}
