<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\CategoryManager;
use App\Model\DescriptionGameModel;
use App\Model\UserConnectionModel;

class DescriptionGameController extends AbstractController
{
    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index(int $id, int $gameId = null)
    {
        session_start();
        $gameModel = new DescriptionGameModel();
        $gameCategory = new CategoryManager();
        $userModel = new UserConnectionModel();
        $gameStatusList = "";
        $gameModel->GameIsAlreadyInUserList($gameId, $gameModel->getUserId($_SESSION['username']));
        if ($gameId !== null) {
            if ($userModel->isConnected() && !$gameModel->GameIsAlreadyInUserList($gameId, $gameModel->getUserId($_SESSION['username']))) {
                $gameModel->addToMyList($gameId);
                echo "Votre jeu a été ajouter a votre liste";
            }elseif ($userModel->isConnected() && $gameModel->GameIsAlreadyInUserList($gameId, $gameModel->getUserId($_SESSION['username']))) {
                echo "Le jeu est déjà dans votre liste";
            } else {
                header('Location: /login');
                // to do
                // metre dans les cookie id jeu
            }
        }
        $tagsIds = $gameCategory->selectAllCategoryFromGameId($id);
        $nameTags = [];
        foreach ($tagsIds as $value) {
            $nameTags[] = $gameCategory->selectNameByTagId($value['genre_id']);
        }
        return $this->twig->render(
            'Home/descriptionGame.html.twig',
            ['game' => $gameModel->selectOneById($id), 'like' => $gameModel->selectLikeById($id), 'tags' => $nameTags, 'gameStatusList' => $gameStatusList]
        );
    }
}
