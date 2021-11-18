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
    private DescriptionGameModel $gameModel;
    private CategoryManager $gameCategory;
    private UserConnectionModel $userModel;
    private GameStatusController $statusController;

    public function __construct()
    {
        parent::__construct();
        $this->gameModel = new DescriptionGameModel();
        $this->gameCategory = new CategoryManager();
        $this->userModel = new UserConnectionModel();
        $this->statusController = new GameStatusController();
    }
    public function index(int $id, int $gameId = null)
    {
        $nameTags = $this->getTag($id);
        $inList = false;
        $gameStatusList = $this->addGameToList($gameId);
        $reviewButtonStatus = ['outline-', 'outline-'];
        $statusGame = [];
        $isGet = true;
        $checked = $this->statusController->getCheckedRequestGet($id);
        if ($this->userModel->isConnected()) {
            $inList = $this->gameModel->gameIsAlreadyInUserList($id, $this->gameModel->getUserId());
            if ($this->userModel->isConnected() && $inList) {
                if (!isset($_POST['like']) && !isset($_POST['dislike']) && !isset($_POST['submit_commentaire'])) {
                    $isGet = $this->statusController->changeStatusGame($id);
                    $statusGame = $this->statusController->getStatusGame($id);
                }
                $this->reviewManager($id);
                $reviewButtonStatus = $this->statusController->getStatusGameReview($id);
            }
        }
        $getAllCommentsByGame = $this->gameModel->selectAllCommentsByGame();
        $error = $this->addComment();
        return $this->twig->render(
            'Home/descriptionGame.html.twig',
            [
                'game' => $this->gameModel->selectOneById($id),
                'like' => $this->gameModel->selectLikeById($id),
                'tags' => $nameTags,
                'inList' => $inList,
                'reviewStatus' => $reviewButtonStatus,
                'gameStatus' => $statusGame,
                'error' => $error,
                'getAllCommentsByGame' => $getAllCommentsByGame,
                'gameStatusList' => $gameStatusList
                'isGet' => $isGet,
                'checked' => $checked
            ]
        );
    }

    public function addGameToList($gameId)
    {
        if ($gameId !== null) {
            if ($this->userModel->isConnected()) {
                $this->gameModel->addToMyList($gameId);
                return "Ce jeu a bien été ajouté à votre liste";
            } else {
                header('Location: /login');
            }
        }
        return '';
    }

    public function getTag(int $id)
    {
        $tagsIds = $this->gameCategory->selectAllCategoryFromGameId($id);
        $nameTags = [];
        foreach ($tagsIds as $value) {
            $nameTags[] = $this->gameCategory->selectNameByTagId($value['genre_id']);
        }
        return $nameTags;
    }
    public function reviewManager(int $id)
    {
        $userReview = $this->gameModel->selectGameReviewFromUserId($id, $this->gameModel->getUserId());
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if (isset($_POST['like']) || isset($_POST['dislike'])) {
                $review = array_keys($_POST);
                if (!$userReview) {
                    $this->gameModel->reviewGame($id, $this->gameModel->getUserId(), $review[0]);
                } else {
                    $this->gameModel->updateReviewGame($id, $this->gameModel->getUserId(), $review[0]);
                }
            }
        }
    }

    public function addComment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['submit_commentaire'])) {
                if (isset($_POST['commentaire']) && !empty($_POST['commentaire'])) {
                    $commentaire = $_POST['commentaire'];
                    $getGameId = $this->gameModel->getGameId();
                    $getUserId = $this->gameModel->getUserId();
                    $this->gameModel->insertIntoComment($commentaire, $getGameId, $getUserId);
                } elseif (empty($_POST['commentaire'])) {
                    return "Votre commentaire ne doit pas etre vide";
                }
            }
        }
    }
}
