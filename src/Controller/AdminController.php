<?php

namespace App\Controller;

class AdminController extends AbstractController
{
    public function index()
    {
        return $this->twig->render(
            'Home/admin.html.twig',
        );
    }
}
