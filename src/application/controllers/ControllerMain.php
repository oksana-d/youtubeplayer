<?php
namespace src\application\controllers;

use src\application\core\Controller;
use src\application\models\ModelMain;
use src\application\YouTubeVideo;
use DateTime;

class ControllerMain extends Controller
{

    public function indexAction()
    {
        $this->view->generate('MainView.php', 'TemplateView.php');
    }

    public function searchAction()
    {
        if($_POST){
            $this->model = new ModelMain();
            if($this->model->checkExistsQuery($_POST['searchInput']) == NULL) {//записываем результат в бд, если такого запроса нет в бд
                if(($idPage = $this->model->getPage(1)) != NULL) {//если nextPageToken, prevPageToken первой страницы есть в бд
                    $video = new YouTubeVideo();
                    $dataBySearch = $video->search($_POST['searchInput']);
                    $videosDate   = $this->getDataVideo($dataBySearch->getItems());
                    if ($idQuery = $this->model->saveQueryData($_POST['searchInput'])) {
                        if (isset($_COOKIE['query'])) {
                            unset($_COOKIE['query']);
                        }
                        setcookie("query", serialize($this->model->getQuery($idQuery)), 0, '/');
                        if (isset($_COOKIE['page'])) {
                            unset($_COOKIE['page']);
                        }
                        setcookie("page", serialize($idPage), 0, '/');
                        $this->model->saveVideoData($idQuery, $idPage['idPage'], $videosDate);
                    }
                }
                else{//если nextPageToken, prevPageToken первой страницы нет в бд
                    $video = new YouTubeVideo();
                    $dataBySearch = $video->search($_POST['searchInput']);
                    $videosDate   = $this->getDataVideo($dataBySearch->getItems());
                    if ($idQuery = $this->model->saveQueryData($_POST['searchInput'])) {
                        if (isset($_COOKIE['query'])) {
                            unset($_COOKIE['query']);
                        }
                        setcookie("query", serialize($this->model->getQuery($idQuery)), 0, '/');
                        if ($idPage = $this->model->savePageData($dataBySearch->toSimpleObject()->nextPageToken,
                            $dataBySearch->toSimpleObject()->prevPageToken)) {
                            if (isset($_COOKIE['page'])) {
                                unset($_COOKIE['page']);
                            }
                            setcookie("page", serialize($this->model->getPage($idPage)), 0, '/');
                            $this->model->saveVideoData($idQuery, $idPage, $videosDate);
                        }
                    }
                }
            }
            else{//если такой запрос уже есть в бд, то выводим первую страницу из бд
                $videosDate = $this->model->getDataOnQuery($_POST['searchInput']);
                if(isset($_COOKIE['page'])){
                    unset($_COOKIE['page']);
                }
                setcookie("page", serialize($this->model->getPage($videosDate[0]['page'])) ,0, '/');
                if(isset($_COOKIE['query'])){
                    unset($_COOKIE['query']);
                }
                setcookie("query", serialize($this->model->getQuery($videosDate[0]['query'])) ,0, '/');
            }
            $this->view->ajaxGenerate('VideoPage.php',['videos' => $videosDate]);
        }
    }

    public function getNextPageAction()
    {
        if(unserialize($_COOKIE['page'])['nextPageToken'] != NULL) {
            $page         = unserialize($_COOKIE['page'])['idPage'] + 1;//текущий номер страницы
            $video        = new YouTubeVideo();
            $dataBySearch = $video->nextPage(unserialize($_COOKIE['query'])['queryText'],
                unserialize($_COOKIE['page'])['nextPageToken']);
            $videosDate   = $this->getDataVideo($dataBySearch->getItems());
            if (isset($_COOKIE['page'])) {
                unset($_COOKIE['page']);
            }
            setcookie("page", serialize([
                    'idPage'        => $page,
                    'nextPageToken' => $dataBySearch->toSimpleObject()->nextPageToken,
                    'prevPageToken' => $dataBySearch->toSimpleObject()->prevPageToken
                ]), 0, '/');
            $this->view->ajaxGenerate('VideoPage.php', ['videos' => $videosDate]);
        }
    }

    public function getDataVideo(array $videos)
    {
        $dataset = [];
        array_walk($videos, function ($value) use (&$dataset){
            $dataset[] = [
                'id' => json_decode((json_encode($value->toSimpleObject()->id)),true)['videoId'],
                'title' => $value->toSimpleObject()->snippet->title,
                'preview' =>  $value->toSimpleObject()->snippet->thumbnails->medium->url,
                'publishedAt' => $this->timeFormatting($value->toSimpleObject()->snippet->publishedAt),
            ];
        });

        return $dataset;
    }

    public function timeFormatting($data)
    {
        $arr = [
            'января',
            'февраля',
            'марта',
            'апреля',
            'мая',
            'июня',
            'июля',
            'августа',
            'сентября',
            'октября',
            'ноября',
            'декабря'
        ];

        $dat = new DateTime($data);
        $date = $dat->format('d').' '.$arr[$dat->format('m')-1].' '.$dat->format('Y').' г.';
        return $date;
    }
}