<?php

/**
 * Fichier de compilation de l'application
 * 
 * Ce fichier génére la page finale HTML avant de retourer le résultat au navigateur
 */

 // Dans le cas ou la route est vide, on force le programme à redéfinir la route vers la page 404

if (empty($route))
{
    $route = end($routes);
}

/**
 * Récupération des éléments de la route qui définissent le controleur
 */

 // Si ce parametre est vide, on arrete le programme
if (!isset($route[2]) || empty($route[2]))
{
    throw new Exception("Le controleur n'est pas défini");
}

// Initialisation des variables qui définiront le fichier et la fonction à éxecuter
$controller_exp = $route[2];
$controller_file = null; // Homepage
$controller_path = null; // "../src/controllers/".$controller_file.".php";
$controller_methode = null; // homepage_index

// Récupération des éléments du controleur
$controller = explode(":",$controller_exp);

// Définition du fichier controleur
$controller_file = $controller[0];

$controller_path = "../src/controllers/".$controller_file.".php";

// Définition de la fonction à exécuter
$controller_methode = $controller[1];

/**
 * 
 * 
*/

if (!file_exists($controller_path)){
    throw new Exception("Le fichier controleur de la route  " . $route[0]. " est manquant");
}

include_once ($controller_path);
