<?php
namespace src\application\controllers;

use src\application\core\Controller;

class ControllerAuth extends Controller
{

    public function indexAction()
    {
        $this->view->generate('AuthView.php', 'TemplateView.php');
    }
}