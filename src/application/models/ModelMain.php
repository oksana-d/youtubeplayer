<?php

namespace src\application\models;

use src\application\core\Model;
use src\application\DB;

class ModelMain extends Model
{
    public function checkExistsQuery($query)
    {
        $conn = DB::connect();
        $execute_query = $conn->query("SELECT idQuery FROM query WHERE queryText =?", [$query])[0]['idQuery'];
        return $execute_query;
    }

    public function getDataOnQuery($query){
        $conn = DB::connect();
        $execute_query = $conn->query("select * from query 
			join videoQuery on query.idQuery=videoQuery.`query`
			join video on video.idVideo=videoQuery.video
			where query.queryText=?", [$query]);
        return $execute_query;
    }

    public function saveQueryData($query){
        $conn = DB::connect();
        $execute_query = $conn->query("
            INSERT INTO query (queryText)
            VALUES (?)",
            [$query]);
        if ($execute_query) {
            return $conn->lastInsertId();
        } else return false;
    }

    public function savePageData($nextPageToken, $prevPageToken){
        $conn = DB::connect();
        $execute_query = $conn->query("
            INSERT INTO page (nextPageToken, prevPageToken)
            VALUES (?, ?)",
            [$nextPageToken, $prevPageToken]);
        if ($execute_query) {
            return $conn->lastInsertId();
        } else return false;
    }

    public function saveVideoData($idQuery, $idPage, $videoData)
    {
        $conn = DB::connect();
        foreach ($videoData as $data) {
            $execute_query = $conn->query("
              INSERT INTO video (idVideo, title, preview, publishedAt)
              VALUES (?, ?, ?, ?)
            ", [$data['id'], $data['title'], $data['preview'], $data['publishedAt']]);
            if ($execute_query) {
                self::saveVideoQueryData($idQuery, $data['id'], $idPage);
            } else return false;
        }
    }

    public function saveVideoQueryData($idQuery, $idVideo, $idPage)
    {
        $conn = DB::connect();
        $execute_query = $conn->query("
        INSERT INTO videoQuery (query, video, page)
        VALUES (?, ?, ?)", [$idQuery, $idVideo, $idPage]);
        if ($execute_query) {
            return $conn->lastInsertId();
        } else {
            return false;
        }

    }

    public function getPage($idPage){
        $conn = DB::connect();
        $execute_query = $conn->query("select * from page where idPage=?", [$idPage])[0];
        return $execute_query;
    }

    public function getQuery($idQuery){
        $conn = DB::connect();
        $execute_query = $conn->query("select * from query where idQuery=?", [$idQuery])[0];
        return $execute_query;
    }
}