<?php

//01. Intégration du fichier d'exécution de l'application

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

//08. Compilation de la page (part 1)

//09. Compilation de la page (part 2)