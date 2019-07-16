<?php

function getUserByEmail($email)
{
    GLOBAL $db;

    $sql = "SELECT
        *
    FROM 
        `user`
    WHERE
        email= ".$email."
    
    ";
    $q = $db['main']->query($sql);

    return $q->fetchAll(PDO::FETCH_OBJ);
}

function addUser()
{

}