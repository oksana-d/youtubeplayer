<?php

namespace src\application;
use Google_Client;
use Google_Service_YouTube;
use Google_Service_Exception;

class YouTubeVideo
{

    public $id;
    private $apiKey = 'ВАШ КЛЮЧ';
    private $youtube;

    public function __construct()
    {
        $client = new Google_Client();
        $client->setDeveloperKey($this->apiKey);
        $this->youtube = new Google_Service_YouTube($client);
    }

    public function search(string $query )//Поиск видео по фразе
    {
        $maxResults=48;
        $lang='ru';

        $response = $this->youtube->search->listSearch('snippet',
            array(
                'q' => $query,
                'maxResults' => $maxResults,
                'relevanceLanguage' => $lang,
                'type' => 'video'
            ));

        return $response;
    }

    public  function nextPage($query ,$nextPageToken){//следующая страница результата поиска
        $maxResults=48;
        $lang='ru';

        $response = $this->youtube->search->listSearch('snippet',
            array(
                'q' => $query,
                'maxResults' => $maxResults,
                'relevanceLanguage' => $lang,
                'type' => 'video',
                'pageToken' => $nextPageToken
            ));

        return $response;
    }
}
