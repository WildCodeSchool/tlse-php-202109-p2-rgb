<?php

namespace App\Controller;

class gameCategoryController extends AbstractController
{
    public function index()
    {
        return $this->twig->render('gameCategory/index.html.twig');
    }
}
