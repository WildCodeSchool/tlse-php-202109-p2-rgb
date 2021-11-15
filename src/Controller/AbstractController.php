<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

abstract class AbstractController
{
    protected Environment $twig;
    protected $previousUrl;

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        $loader = new FilesystemLoader(APP_VIEW_PATH);
        $this->twig = new Environment(
            $loader,
            [
                'cache' => false,
                'debug' => (ENV === 'dev'),
            ]
        );
        session_start();
        $this->twig->addExtension(new DebugExtension());
        $this->twig->addGlobal('link', $_SESSION);

        if (
            $_SERVER['REQUEST_METHOD'] === 'GET'
            && ($_SERVER['REQUEST_URI'] != "/signin")
            && isset($_SERVER['HTTP_REFERER'])
        ) {
            $this->previousUrl = $_SERVER['HTTP_REFERER'];
            $_SESSION['previousUrl'] = $_SERVER['HTTP_REFERER'];
        }
    }
}
