<?php
/**
 * Affiche la synthèse du panier client
 *
 * @return void
 */
function order_index()
{
    // Définition du tableau $products (liste des produits du panier)
    $products = [];

    // Intégration de la vue
    include_once "../src/views/order/index.php";   
}

/**
 * Ajoute un produit au panier du client
 *
 * @return void
 */
function order_add()
{
    // Dépendances des Models
    include_once "../src/models/products.php";
    include_once "../src/models/order.php";

    // Récupération de l'ID du produit
    $product_id = isset($_GET['id']) ? (int) trim($_GET['id']): null;

    // test de l'id du produit
    if (empty($product_id))
    {
        setFlashbag("warning","le produit ne peut pas être ajouté au panier");
        redirectToPreviousPage();
    }
    dump( getProduct($product_id));
    // Récupération des données du produit
    $product = getProduct($product_id);

    // Récupération des données du client
    $user_sess_id = session_id();
    $user_id = isset($_SESSION['user']['id']) ? $_SESSION['user']['id']: null;

    // Récupération de la commande du client
    if ($user_id != null)
    {
        $order = getOrderByUser($user_id);
    }
    else
    {
        $order = getOrderByUser($user_sess_id);
    }

    // Creation de la commande (si non existante)
    if (!$order)
    {
        $order = createOrder([
            "session" => $user_sess_id,
            "id" => $user_id
        ]);
    }
    // Ou récupération de l'id de la commande
    else
    {
        $order = $order->id;
    }

    // Récupération des produits de la commande
    $order_products = getOrderProducts($order);
    // Si la requete retourne False
    if (!$order_products)
    {
        // On surcharge $order_products avec un tableau vide
        $order_products = [];
    }

    // On déclare la variable $addProductToOrder avec la valeur TRUE, qui va nous permettre
    // savoir si on ajoute le produit dans la BDD ou non

    $addProductToOrder = true;

    // On boucle sur la liste des produits de la commande
    // On ne rentre pas dans la boucle SI $order_products est un tableau vide

    foreach($order_products as $order_product)
    {

        echo '<hr>';
        // Si le produit est déjà dans la commande
        if ($order_product->id_product == $product['id'])
        {
            // Incrémentation de la quantité
            $isOrderProductOK = updateProductInOrder($product, $order_product->id);

            // Et on passe la valeur de $addProductToOrder à FALSE, ce qui évitera au script
            // d'ajouter une nouvelle ligne dans la BDD

            $addProductToOrder = false;
        }
    }

    // Ajout du produit dans la BDD si $addProductToOrder est TRUE
    if ($addProductToOrder)
    {
        $isOrderProductOK = addProductToOrder($product,$order);
    }


    dump($product);
    dump($user_sess_id);
    dump($user_id);
    dump($order);
}


/**
 * Supprime un produit du panier du client
 *
 * @return void
 */
function order_remove()
{

}