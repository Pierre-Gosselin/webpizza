<?php

/**
 * Fichier d'exécution de l'application
 */

 /**
  * 1. Démarrage de la session 
  * La session va permettre de suivre le visiteur pendant la visite sur le site
  */
 session_start();

//02. Intégration de la configuration
require_once "../config/config.php";

//03. Définition de l'environnement

require_once "../app/environnement.php";

//04. Comportement des erreurs

require_once "../app/err_reporting.php";

//05. Connexions aux bases de données

require_once "../app/dbconnect.php";

//06. Routage de l'application

require_once "../app/routing.php";

//07. Inclusion des fonctions Utils

include_once "../app/utils.php";

//08. Controleur principal ( commun à toutes les pages du site)

include_once "../src/controllers/common.php";

//09. Compilation de la page (part 2 - La compilation finale)

include_once "../app/compile.php";

