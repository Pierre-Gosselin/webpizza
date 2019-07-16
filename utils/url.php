<?php

function url($routeName, $absolute = false) :string
{
    GLOBAL $routes;
    // Parcour la liste des routes
    // Et récupère le path de la route $routeName
    // Définition de la variable base
    $base = "";
    $path = "/404";
    if ($absolute){
        //le shema : http ou https
        $scheme = "http";
        if (isset($_SERVER['REQUEST_SCHEME']))
        {
            $scheme = $_SERVER['REQUEST_SCHEME'];
        }

        $host = "127.0.0.1";
        if (isset($_SERVER['HTTP_HOST']))
        {
            $host = $_SERVER['HTTP_HOST'];
        }

        // Création de la base de l'adresse absolue    
        $base = $scheme . "://" . $host;
    }
    
    if (is_array($routes)){
        foreach ($routes as $route) {
            if ($route[0] == $routeName){
                $path = $route[1];
                break;
            }
        }
    }
    return $base.$path;
}
