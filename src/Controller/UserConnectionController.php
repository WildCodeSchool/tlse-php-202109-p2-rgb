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
                return $this->twig->render(
                    'Home/login.html.twig',
                    [
                        'errors' => $errors,
                        'classError' => 'alert alert-danger m-auto'
                    ]
                );
            }

            if ($userConnection->isRegistered($_POST) === false) {
                return $this->twig->render(
                    'Home/login.html.twig',
                    [
                        'wrongId' => 'Nous ne connaissons pas ce profil. Avez vous un compte ?',
                        'classError' => 'alert alert-danger m-auto'
                    ]
                );
            }

            if (
                !password_verify(
                    $_POST['passwordUser'],
                    $userConnection->isRegistered($_POST)['password']
                )
            ) {
                    $errors['passwordUser'] = "Mot de passe incorrect";
                    return $this->twig->render(
                        'Home/login.html.twig',
                        [
                            'errors' => $errors,
                            'classError' => 'alert alert-danger m-auto'
                        ]
                    );
            }
            session_start();
            $_SESSION['username'] = $_POST['nickname'];
            header('Location:/');
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
        $userConnection = new UserConnectionModel();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $userConnection->errorsInForm($_POST);

            if (!empty($errors)) {
                return $this->twig->render(
                    'Home/signin.html.twig',
                    ['errors' => $errors,
                    'classError' => 'alert alert-danger'
                    ]
                );
            }
        }

        return $this->twig->render('Home/signin.html.twig');
    }
}
