<?php

namespace src\application\models;

use src\application\core\Model;
use src\application\DB;

class ModelAuth extends Model
{
    public function checkExistsEmail($email)
    {
        $conn = DB::connect();
        $executeQuery = $conn->query("SELECT COUNT(idUser) as total FROM user WHERE email =?", [$email])[0];

        return $executeQuery['total'] > 0 ? true : false;
    }

    public function signIn($email,$password)
    {
        $conn = DB::connect();
        $query = "SELECT * FROM `user` WHERE email = '$email'";
        $data = $conn->query($query);

        if($data[0]['password'] === $password)
        {
            $result = true;
        }else{
            $result = false;
        }

        return $result;
    }

    public function signUp($firstname, $surname, $email,$password)
    {
        $conn = DB::connect();
        $query = "INSERT INTO `user` (firstname,lastname,email,password) VALUES('$firstname','$surname','$email','$password')";
        $result = $conn->query($query);

        return $result;
    }
}