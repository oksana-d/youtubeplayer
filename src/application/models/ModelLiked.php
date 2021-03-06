<?php

namespace src\application\models;

use src\application\core\Model;
use src\application\DB;

class ModelLiked extends Model
{
    public function getIdUser($email){
        $conn = DB::connect();
        $execute_query = $conn->query("select idUser from user where email=?", [$email])[0];
        return $execute_query;
    }

    public function getVideo($idUser, $offset){
        $conn = DB::connect();
        $execute_query = $conn->query("select video.idVideo, title, preview, publishedAt from user
                 join `like` on user.idUser=like.idUser
	             join video on video.idVideo=like.idVideo
	        where user.idUser=?  order by video.idVideo asc limit 48 offset ?", [$idUser, $offset]);
        return $execute_query;
    }

    public function removeLike($idUser, $idVideo){
        $conn = DB::connect();
        $execute_query = $conn->query("delete from `like` where `idUser`=? and `idVideo`=?", [$idUser, $idVideo]);
        return $execute_query;
    }

    public function getCountLike($idUser){
        $conn = DB::connect();
        $execute_query = $conn->query("select count(*) from `like` where `like`.idUser=?", [$idUser])[0]['count(*)'];
        return $execute_query;
    }
}