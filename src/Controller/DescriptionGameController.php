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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['submit_commentaire'])) {
                if (isset($_POST['commentaire']) and !empty($_POST['commentaire'])) {
                    $commentaire = $_POST['commentaire'];
                    if (strlen($commentaire) < 5) {
                        $error = "Erreur: Le commentaire doit faire plus de 5 caractères";
                    }
                    $gameModel->insertIntoComment($commentaire);
                }
            }
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
