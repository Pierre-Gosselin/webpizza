<?php

/**
 * Récupére une commande en fonction de l'ID de l'utilisateur ou de la session PHP
 *
 * @param [int|string] $user ID ou PHP sess ID
 * @return void
 */
function getOrderByUser($user)
{
    GLOBAL $db;

    // Définition de la requête
    $sql = "SELECT `id`,`amount` FROM `order` WHERE `id_user`=:user || `sess_user`=:user";

    // Préparation de la requete
    $q = $db['main']->prepare($sql);
    $q->bindParam(':user',$user);

    // Execution de la requete
    $q->execute();

    return $q->fetch(PDO::FETCH_OBJ);
}

/**
 * Creation d'une commande liée à un utilisateur
 *
 * @param [type] $user
 * @return void
 */
function createOrder($user)
{
    GLOBAL $db;

    // Définition de la requête
    $sql = "INSERT INTO `order` (`id_user`,`sess_user`) VALUES (:id_user,:sess_user)";
    $q = $db['main']->prepare($sql);
    $q->bindParam(':id_user',$user['id']);
    $q->bindParam(':sess_user',$user['session'],PDO::PARAM_STR);

    // Execution de la requete
    $q->execute();

    // Retourne l'id de la commande

    return $db['main']->lastInsertId();
}

/**
 * Retourne la liste des produits d'une commande
 *
 * @param [int] $id_order ID de la commande
 * @return void
 */
function getOrderProducts($id_order)
{
    GLOBAL $db;

    // Définition de la requête
    $sql = "SELECT `id`,`id_product`,`quantity`,`price` FROM `order_product` WHERE `id_order`=:id_order";

    // Préparation de la requête
    $q = $db['main']->prepare($sql);
    $q->bindParam(':id_order',$id_order, PDO::PARAM_INT);
    
    // Execution de la requête
    $q->execute();

    return $q->fetchAll(PDO::FETCH_OBJ);
}

function addProductToOrder($product, $order)
{

    GLOBAL $db;

    $sql = "INSERT INTO `order_product` (`id_order`,`id_product`,`quantity`,`price`,`amount`) VALUES (:id_order, :id_product, :quantity ,:price ,:amount)";

    $q = $db['main']->prepare($sql);
    $q->bindValue(':id_order',$order, PDO::PARAM_INT);
    $q->bindValue(':id_product',$product['id'],PDO::PARAM_INT);
    $q->bindValue(':quantity', 1,PDO::PARAM_INT);
    $q->bindValue(':price',$product['price']);
    $q->bindValue(':amount',$product['price']);    

    $q->execute();

    return $db['main']->lastInsertId();
}

function updateProductInOrder($product, $order_product_id)
{
    GLOBAL $db;

    $sql = "UPDATE `order_product` SET `quantity`=, ";

    $q = $db['main']->prepare($sql);
    $q->execute();
}