<?php
/**
 * Fichier de configuration des connections aux bases de données
 */

 $db_config = [

    // Base de données principale
    "main" => [ // Nom de la connection, utilisé uniquement dans nos fichier PHP. donnera $db['main']
        "type" => "", // Type de SGBD
        "host" => "", // ADresse du serveur de base de donnée
        "port" => "", // Port de  connection
        "user" => "", // Nom d'utilisateur de la BDD
        "pass" => "", // Mot de passe de l'utilisateur
        "schema" => "", // Nom de la base de données
        "charset" => "utf8" // Jeux de carctère de la base de donnée
    ]
];