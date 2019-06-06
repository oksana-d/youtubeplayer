<?php
namespace src\application\controllers;

use src\application\core\Controller;
use src\application\models\ModelLiked;

class ControllerLiked extends Controller
{

    public function indexAction()
    {
        session_start();
        if(isset($_SESSION['login'])) {
            $this->model = new ModelLiked();
            $idUser      = $this->model->getIdUser($_SESSION['login']);
            $count       = $this->model->getCountLike($idUser['idUser']);
            $videoData   = $this->model->getVideo($idUser['idUser'], 0);
            if (isset($_COOKIE['like'])) {
                unset($_COOKIE['like']);
            }
            setcookie("like", json_encode([
                'count' => $count,
                'shown' => 48
            ]), 0, '/');
            $this->view->generate('LikedView.php', 'TemplateView.php', ['videos' => $videoData]);
        }
        else{
            $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
            header('Location: '.$host);
            exit;
        }
    }

    public function removeAction(){
        session_start();
        $this->model = new ModelLiked();
        $idUser = $this->model->getIdUser($_SESSION['login']);
        $this->model->removeLike($idUser['idUser'], $_POST['id']);
        $videoData = $this->model->getVideo($idUser['idUser'], 0);
        $this->view->ajaxGenerate('LikedVideoPage.php', ['videos' => $videoData]);
        echo(json_encode(true));
    }

    public function getNextPageAction(){
        session_start();
        $this->model = new ModelLiked();
        $idUser = $this->model->getIdUser($_SESSION['login']);
        $countAll = $this->model->getCountLike($idUser['idUser']);
        $count = json_decode($_COOKIE['like'], true)['shown'] + 48;
        $videoData = $this->model->getVideo($idUser['idUser'], json_decode($_COOKIE['like'], true)['shown']);
        if(count($videoData) == 0){
            echo('Вы еще ничего не добавили в список понравившихся');
            exit;
        }
        if (isset($_COOKIE['like'])) {
            unset($_COOKIE['like']);
        }
        setcookie("like", json_encode([
            'count'        => $countAll,
            'shown'        => $count
        ]), 0, '/');
        $this->view->ajaxGenerate('LikedVideoPage.php', ['videos' => $videoData]);
    }

    public function getPrevPageAction(){
        session_start();
        $this->model = new ModelLiked();
        $idUser = $this->model->getIdUser($_SESSION['login']);
        $countAll = $this->model->getCountLike($idUser['idUser']);
        $count = json_decode($_COOKIE['like'], true)['shown'] - 96;
        $videoData = $this->model->getVideo($idUser['idUser'], $count);
        if (isset($_COOKIE['like'])) {
            unset($_COOKIE['like']);
        }
        setcookie("like", json_encode([
            'count'        => $countAll,
            'shown'        => $count
        ]), 0, '/');
        $this->view->ajaxGenerate('LikedVideoPage.php', ['videos' => $videoData]);
    }
}