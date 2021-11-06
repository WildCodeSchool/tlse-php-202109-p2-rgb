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
    public function index(int $id)
    {
        $gameModel = new DescriptionGameModel();
        $gameCategory = new CategoryManager();
        $tagsIds = $gameCategory->selectAllCategoryFromGameId($id);
        foreach ($tagsIds as $key => $value) {
            $nameTags[] = $gameCategory->selectNameByTagId($value['genre_id']);
        }
        return $this->twig->render(
            'Home/descriptionGame.html.twig',
            ['game' => $gameModel->selectOneById($id), 'like' => $gameModel->selectLikeById($id), 'tags' => $nameTags]
        );
    }
}
