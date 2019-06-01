<?php
namespace src\application\controllers;

use src\application\core\Controller;
use src\application\models\ModelAuth;

class ControllerAuth extends Controller
{

    public function indexAction()
    {
        $this->view->generate('AuthView.php', 'TemplateView.php');
    }

    public function checkabsenceAction()
    {
        $this->model = new ModelAuth();
        if (isset($_POST['email'])) {
            if ($this->model->checkExistsEmail($_POST['email'])) {
                echo(json_encode(true));
            } else {
                echo(json_encode(false));
            }
        }
    }

    public function signinAction()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $this->model = new ModelAuth();
            $email = $_POST['email'];
            $password = $_POST['password'];
            $check = $this->model->signIn($email,$password);

            if($check == true)
            {
                session_start();
                $_SESSION['isAuth'] = 'true';
                $_SESSION['login'] = $email;
                echo(json_encode(true));
            }else{
                echo(json_encode(false));
            }
        }
    }
}