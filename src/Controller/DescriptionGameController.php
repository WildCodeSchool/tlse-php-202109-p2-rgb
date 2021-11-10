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
        if ($gameId !== null) {
            if (
                $userModel->isConnected() && !$gameModel->gameIsAlreadyInUserList(
                    $gameId,
                    $gameModel->getUserId()
                )
            ) {
                $gameModel->addToMyList($gameId);
                $gameStatusList = "Ce jeu a bien été ajouté à votre liste";
            } elseif (
                $userModel->isConnected() && $gameModel->gameIsAlreadyInUserList(
                    $gameId,
                    $gameModel->getUserId()
                )
            ) {
                $gameStatusList = "Ce jeu est déjà dans votre liste";
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
            [
                'game' => $gameModel->selectOneById($id),
                'like' => $gameModel->selectLikeById($id),
                'tags' => $nameTags,
                'gameStatusList' => $gameStatusList
            ]
        );
    }
}
