<?php
namespace src\application\controllers;

use src\application\core\Controller;

class ControllerMain extends Controller
{

    public function indexAction()
    {
        $this->view->generate('MainView.php', 'TemplateView.php');
    }
}