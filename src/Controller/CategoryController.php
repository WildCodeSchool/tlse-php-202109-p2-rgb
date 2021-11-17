<?php

namespace App\Controller;

use App\Model\CategoryManager;
use App\Model\DescriptionGameModel;
use App\Model\SearchManager;

class CategoryController extends AbstractController
{
    public function index(int $id)
    {
        $gameReviewManager = new DescriptionGameModel();
        $gameManager = new CategoryManager();
        $search = new SearchManager();
        $path = $_SERVER['PATH_INFO'] . "?";
        $category = $gameManager->selectByGenre($id);
        $gameInfos = $gameManager->selectAllGamesFromCategoryId($id);
        $gameReview = [];
        foreach ($gameInfos as $gameInfo) {
            $gameReview[] = $gameReviewManager->selectLikeById($gameInfo['game_id']);
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $search->searchByKeyWordOnOneCategory($id, $_POST['search']);

            return $this->twig->render(
                'Category/index.html.twig',
                [
                    'category' => $category,
                    'gameInfos' => $gameInfos,
                    "link" => $_SESSION,
                    "path" => $path,
                    "result" => $result,
                ]
            );
        }

        return $this->twig->render(
            'Category/index.html.twig',
            [
                'category' => $category,
                'gameInfos' => $gameInfos,
                'gameReviews' => $gameReview,
                "link" => $_SESSION,
                "path" => $path,
            ]
        );
    }
}
