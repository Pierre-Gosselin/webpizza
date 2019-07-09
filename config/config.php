<?php
/**
 * Fichier de configuration général de l'application
 * 
 * 1. Definition des constantes
 * 2. Définition des variables d'environnement d'exécution
 * 3. Définition des variables de base de données
 * 4. Définition des variables de routage
 * 5. Définition des expressions régulères
 */

 /**
 * 1. Definition des constantes
 */

 //  Definition du titre du site
 // true -> N'est pas sensible à la case
define('WEBSITE_TITLE', "WebPizza, les meilleures pizzas du WEB !",true);


// Définir le chemin du répertoire "utils"

define('UTILS_PATH',"../utils/");



/**
 * 2. Définition des variables d'environnement d'exécution
 */
// Environnement de développement ou production
// les valeurs peuvent être : "prod" ou "dev"
// Par défault, on considère que l'application s'exécute en environnement de PROD
$env = "prod";

// Liste des domaines que l'on considères comme étant des environnements de développement.
$dev_domains =[
    "127.0.0.1",
    "localhost",
    "webpizza.local"
];

 /**
* 3 Définition des variables de base de données
*/

// Liste des configurations de connexions aux bases de données par défaut
$db_config = [];

// Liste des connexions aux bases de données
// Cette liste sera nourris par le fichier db_connect.php

$db = [];

//  Inclusion de la config de la base de données
require_once "database.php";


/**
 * 4 Définition des variables de routage
 */

/**
 * 5 Définition des expressions régulères
 */
