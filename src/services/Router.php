<?php
namespace App\services;

class Router {

    public function parseRoute()
    {
        $route = [];
        if (isset($_GET["route"]))
        {
                $routeParam = explode("/", $_GET["route"]);
                $route["route"] = $routeParam[0];
        } else 
        {
                $route["route"] = "home";
        }

        if (isset($routeParam) && count($routeParam) === 2)
        {
                $id = $routeParam["1"];
        } else {
                $id = null;
        }

        $route["param"] = $id;
        return $route;
    }

    public function route()
    {
        $route = $this->parseRoute();
        
        require "src/views/layout.phtml";
    }
}
