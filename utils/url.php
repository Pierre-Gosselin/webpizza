<?php
function url($routeName)
{
    // Parcour la liste des routes
    foreach ($routes as $route) {
        if ($route[0] == $routeName){
            return $route[1];
        }
    }
}
