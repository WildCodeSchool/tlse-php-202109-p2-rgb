<?php

namespace App\Controller;

class AdminController extends AbstractController
{
    public function index()
    {
        session_start();
        return $this->twig->render(
            'Home/admin.html.twig',
            ['link' => $_SESSION,]
        );
    }
}
