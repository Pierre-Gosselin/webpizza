<?php

function getUserByEmail($email, $secured=true)
{
    GLOBAL $db;

    // Définition de la requête
    $sql = "SELECT `id`,`fullname`,`email`,`pwd` FROM `user` WHERE `email`=:email";

    // Préparation de la requête
    $q = $db['main']->prepare($sql);
    $q->bindParam(':email',$email, PDO::PARAM_STR);

    // Exécution de la requête
    $q->execute();

    // Récupération du résultat
    $r = $q->fetch(PDO::FETCH_ASSOC);
    // Si la requête retourne une réponse
    if ($r)
    {
        // si on sécurise la requête
        if ($secured)
        {
            // On supprime le mot de passe de la réponse
            unset($r['pwd']);
        }
        return $r;
    }
    return false;
}

function addUser(array $user)
{
    GLOBAL $db;

    $sql = "INSERT INTO `user` (`firstname`,`lastname`,`email`,`pwd`) VALUES (:firstname,:lastname,:email,:password) ";

    $q = $db['main']->prepare($sql);

    $q->bindParam(':firstname',$user['firstname'], PDO::PARAM_STR);
    $q->bindParam(':lastname',$user['lastname'], PDO::PARAM_STR);
    $q->bindParam(':email',$user['email'], PDO::PARAM_STR);
    $q->bindParam(':password',$user['password'], PDO::PARAM_STR);

    return $q->execute();
}

function addPwdToken($token, $user_id)
{
    GLOBAL $db;
    $token_expiration = time() + 3600;
    $sql = "UPDATE `user` SET `pwd_token`=:token, `pwd_token_expire`=:token_expiration WHERE `id`=:id";

    $q = $db['main']->prepare($sql);
    $q->bindParam(':token',$token, PDO::PARAM_STR);
    $q->bindParam(':id',$user_id, PDO::PARAM_INT);
    $q->bindParam(':token_expiration',$token_expiration, PDO::PARAM_INT);

    return $q->execute();
}

function getUserByToken($token)
{
    GLOBAL $db;

    $sql ="SELECT `id`,`fullname`,`email`,`pwd_token_expire` FROM `user` WHERE `pwd_token` = :token";

    $q = $db['main']->prepare($sql);

    $q->bindParam(':token',$token, PDO::PARAM_STR);

    return $q->execute();
}

function renewPassword($user) 
{
    global $db;
    
    // Definition de la requête
    $sql = "UPDATE `user` SET `password`=:password, `pwd_token`=NULL, `pwd_token_expire`=NULL WHERE `id`=:id";
    // Préparation de la requete
    $query = $db['main']->prepare($sql);
    $query->bindValue(':password', $user['password'], PDO::PARAM_STR);
    $query->bindValue(':id', $user['id'], PDO::PARAM_INT);
    // Execution de la requete
    return $query->execute();
}