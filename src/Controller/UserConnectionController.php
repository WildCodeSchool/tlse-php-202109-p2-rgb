<?php

namespace App\Controller;

use App\Model\UserConnectionModel;

class UserConnectionController extends AbstractController
{
    /**
     * login
     *
     * @return mixed
     */
    public function login()
    {
        $userConnection = new UserConnectionModel();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $userConnection->errorsInForm($_POST);

            if (!empty($errors)) {
                return $this->twig->render('Home/login.html.twig', ['errors' => $errors]);
            }
            if ($userConnection->isRegistered($_POST) === false) {
                return $this->twig->render('Home/signin.html.twig');
            }
            session_start();
            $_SESSION['username'] = $_POST['nickname'];
            return $this->twig->render('Home/index.html.twig');
        }
        return $this->twig->render('Home/login.html.twig');
    }

    /**
     * signin
     *
     * @return string
     */
    public function signin()
    {
        return $this->twig->render('Home/signin.html.twig');
    }
}
