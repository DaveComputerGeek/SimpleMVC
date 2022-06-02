<?php

namespace DaveComputerGeek\SimpleMVC;

class App
{
    private $router;

    public function __construct()
    {
        require_once __DIR__ . "/Router.php";
        $this->router = new Router;
    }

    public function getRouter()
    {
        return $this->router;
    }
}