<?php

/**
 * Fichier de chargement automatique des scripts du répertoire "utils"
 */

 if (!defined('UTILS_PATH'))
 {
     define('UTILS_PATH',null);
 }

 // Si UTILS_PATH n'est pas null
 // On scan le répertoire "utils" (fonction "scandir") si celui_ci existe
 // (fonction "exists" ) ou "is_dir")
 // On liste / parcour les fichier du répertoire
 // on filtre les fichiers pour conserver uniquement les fichiers en ".php"
 // On inclus les fichiers !

 // et on test la fonction dump();
// Si UTILS_PATH n'est pas définit à null, c'est à dire que UTILS_PATH est bien définit en amont (dans le fichier config.php)
if (UTILS_PATH != null)
{
    // Est ce que UTILS_PATH (../utils/) est un répertoire
    if (is_dir(UTILS_PATH))
    {
        // Scanner le répertoire UTILS_PATH
        $utils_scan = scandir(UTILS_PATH);
        // Une boucle sur la liste des entrées $utils_scan
        foreach ($utils_scan as $file) {
            // Filtre les fichiers terminant par ".php"
            if (preg_match('/\.php$/',$file) == 1){
                $file = UTILS_PATH.$file;
                include_once $file;
            }         
        }
    }
}
