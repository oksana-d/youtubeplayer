<?php
namespace src\application\core;

class Controller
{
    public $model;
    public $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public function action_index()
    {

    }
}