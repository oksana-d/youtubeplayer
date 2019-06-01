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

    public function checkAction()
    {
        $this->model = new ModelAuth();
        if (isset($_POST['email'])) {
            if ($this->model->checkExistsEmail($_POST['email'])) {
                echo(json_encode(false));
            } else {
                echo(json_encode(true));
            }
        }
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

    public function lettersonlyAction(){
        if (isset($_POST['firstname'])) {
            if (preg_match('/^[а-я]+$/ui', $_POST['firstname']) || preg_match('/^[a-z]+$/i', $_POST['firstname'])) {
                echo(json_encode(true));
            } else {
                echo(json_encode(false));
            }
        }
        if (isset($_POST['lastname'])) {
            if (preg_match('/^[а-я]+$/ui', $_POST['lastname']) || preg_match('/^[a-z]+$/i', $_POST['lastname'])) {
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

    public function signupAction()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $this->model = new ModelAuth();
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $signup = $this->model->signUp($firstname,$lastname,$email,$password);

            session_start();
            if($signup == true)
            {
                session_start();
                $_SESSION["isAuth"] = true;
                $_SESSION["login"] = $email;
                echo(json_encode(true));
            }else{
                echo(json_encode(false));
            }
        }
    }

    public function logoutAction(){
        session_start();
        if(isset($_SESSION['isAuth']) && $_SESSION['isAuth'] == 'true'){
            session_destroy();
            $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
            header('Location: '.$host);
            exit;
        }
    }
}