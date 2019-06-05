<?php
namespace src\application\controllers;

use src\application\core\Controller;
use src\application\models\ModelLiked;

class ControllerLiked extends Controller
{

    public function indexAction()
    {
        session_start();
        $this->model = new ModelLiked();
        $idUser = $this->model->getIdUser($_SESSION['login']);
        $videoData = $this->model->getVideo($idUser['idUser']);
        $this->view->generate('LikedView.php', 'TemplateView.php', ['videos' => $videoData]);
    }

    public function removeAction(){
        session_start();
        $this->model = new ModelLiked();
        $idUser = $this->model->getIdUser($_SESSION['login']);
        $this->model->removeLike($idUser['idUser'], $_POST['id']);
        $videoData = $this->model->getVideo($idUser['idUser']);
        $this->view->ajaxGenerate('LikedView.php', ['videos' => $videoData]);
        echo(json_encode(true));
    }
}