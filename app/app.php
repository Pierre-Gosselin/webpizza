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

include_once "../app/utils.php";

// include_once UTILS_PATH."dump.php";
// include_once "../utils/flashbag.php";
// include_once "../utils/getEnumData.php";
// include_once "../utils/getUserLanguages.php";
// include_once "../utils/randstr.php";
// include_once "../utils/redirect.php";
// include_once "../utils/url.php";


//08. Compilation de la page (part 1 - Le controleur principal)

//09. Compilation de la page (part 2 - La compilation finale)

include_once "../app/compile.php";