<?php
namespace src\application\controllers;

use src\application\core\Controller;

class Controller404 extends Controller
{

    public function indexAction()
    {
        $this->view->generate('404.php', 'TemplateView.php');
    }
}