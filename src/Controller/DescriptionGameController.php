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

    public function __construct()
    {
        parent::__construct();
        $this->gameModel = new DescriptionGameModel();
        $this->gameCategory = new CategoryManager();
        $this->userModel = new UserConnectionModel();
    }
    public function index(int $id, int $gameId = null)
    {
        $nameTags = $this->getTag($id);
        $inList = false;
        $gameStatusList = $this->addGameToList($gameId);
        $reviewButtonStatus = ['outline-', 'outline-'];
        if ($this->userModel->isConnected()) {
            $inList = $this->gameModel->gameIsAlreadyInUserList($id, $this->gameModel->getUserId());
            if ($this->userModel->isConnected() && $inList) {
                $this->reviewManager($id);
                $userReview = $this->gameModel->selectGameReviewFromUserId($id, $this->gameModel->getUserId());
                if (!$userReview) {
                    $reviewButtonStatus = ['outline-', 'outline-'];
                } elseif ($userReview['like'] === 'like') {
                    $reviewButtonStatus = ['', 'outline-'];
                } else {
                    $reviewButtonStatus = ['outline-', ''];
                }
            }
        }
        $statusGame=$this->changeStatusGame($id);
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
                'gameStatusList' => $gameStatusList
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
                    return "Votre commentaire ne doit pas être vide";
                }
            }
        }
    }

    public function changeStatusGame($gameId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userReview = $this->gameModel->selectGameReviewFromUserId($gameId, $this->gameModel->getUserId());
            if (isset($_POST['statusChoice'])) {
                $status = $_POST['statusChoice'];
                if (!$userReview) {
                    $this->gameModel->addStatusGameByUserId($status, $gameId, $this->gameModel->getUserId());
                } else {
                    $this->gameModel->updateStatusGameByUserId($status, $gameId, $this->gameModel->getUserId());
                }
            }
        }
    }
}
