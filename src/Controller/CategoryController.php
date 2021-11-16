<?php

namespace App\Controller;

use App\Model\CategoryManager;
use App\Model\DescriptionGameModel;
use App\Model\UserConnectionModel;

class CategoryController extends AbstractController
{
    public function index(int $id)
    {
        $gameReviewManager = new DescriptionGameModel();
        $gameManager = new CategoryManager();
        $category = $gameManager->selectByGenre($id);
        $gameInfos = $gameManager->selectAllGamesFromCategoryId($id);
        $gameReview = [];
        foreach ($gameInfos as $gameInfo) {
            $gameReview[] = $gameReviewManager->selectLikeById($gameInfo['game_id']);
        }
        return $this->twig->render(
            'Category/index.html.twig',
            [
                'category' => $category,
                'gameInfos' => $gameInfos,
                'gameReviews' => $gameReview,
                "link" => $_SESSION
            ]
        );
    }
}
