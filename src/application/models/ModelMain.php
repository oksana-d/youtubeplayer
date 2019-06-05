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
            if (self::getVideo($data['idVideo']) == NULL) {
                $execute_query = $conn->query("
              INSERT INTO video (idVideo, title, preview, publishedAt)
              VALUES (?, ?, ?, ?)
            ", [$data['idVideo'], $data['title'], $data['preview'], $data['publishedAt']]);
                if ($execute_query) {
                    self::saveVideoQueryData($idQuery, $data['idVideo'], $idPage);
                } else {
                    return false;
                }
            } else self::saveVideoQueryData($idQuery, $data['idVideo'], $idPage);
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

    public function saveVideo($data)
    {
        $conn = DB::connect();
        $execute_query = $conn->query("
              INSERT INTO video (idVideo, title, preview, publishedAt)
              VALUES (?, ?, ?, ?)
            ", [$data['id'], $data['title'], $data['preview'], $data['publishedat']]);
        if($execute_query){
            return true;
        } else return false;
    }

    public function getVideo($idVideo){
        $conn = DB::connect();
        $execute_query = $conn->query("select * from video where idVideo=?", [$idVideo])[0];
        return $execute_query;
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

    public function getIdUser($email){
        $conn = DB::connect();
        $execute_query = $conn->query("select idUser from user where email=?", [$email])[0];
        return $execute_query;
    }

    public function putLike($idUser, $idVideo){
        $conn = DB::connect();
        $execute_query = $conn->query("
            INSERT INTO `like` (`idUser`, `idVideo`)
            VALUES (?, ?)", [$idUser, $idVideo]);
        return $execute_query;
    }

    public function getLike($idUser, $idVideo){
        $conn = DB::connect();
        $execute_query = $conn->query("select `idLike` from `like` where `idUser`=? and `idVideo`=?", [$idUser, $idVideo]);
        return $execute_query;
    }

    public function removeLike($idUser, $idVideo){
        $conn = DB::connect();
        $execute_query = $conn->query("delete from `like` where `idUser`=? and `idVideo`=?", [$idUser, $idVideo]);
        return $execute_query;
    }
}