<?php

/**
 * Fonction dédiée à l'affichage des pizzas
 */


function products_pizzas()
{
    // Inclusion de la dépendance "Products model"
    include_once "../src/models/products.php" ;

    // Récupération des données de type "pizza"
    $productsModel = productsBuilder(getPizzas());

    // Titre de la page
    $pageTitle = "Nos pizzas";

    // Intégration de la vue "products"
    include_once "../src/views/products/index.php";
}

function products_pastas()
{
    include_once "../src/models/products.php" ;
    $productsModel = productsBuilder(getPastas());
    $pageTitle = "Nos pates";
    include_once "../src/views/products/index.php";
    
}
function products_salads()
{
    include_once "../src/models/products.php" ;
    $productsModel = productsBuilder(getSalad());
    $pageTitle = "Nos salades";
    include_once "../src/views/products/index.php";
}
function products_desserts()
{
    include_once "../src/models/products.php" ;
    $productsModel = productsBuilder(getDesserts());
    $pageTitle = "Nos désserts";
    include_once "../src/views/products/index.php";
}

function products_drinks()
{
    include_once "../src/models/products.php" ;
    $productsModel = productsBuilder(getDrinks());
    $pageTitle = "Nos boissons";
    include_once "../src/views/products/index.php";
}

function products_starter()
{
    include_once "../src/models/products.php" ;
    $productsModel = productsBuilder(getStarters());
    $pageTitle = "Nos entrées";
    include_once "../src/views/products/index.php";
}


function products_menus()
{
    include_once "../src/models/products.php" ;
    $productsModel = productsBuilder(getMenus());
    $pageTitle = "Nos menus";
    include_once "../src/views/products/index.php";
}

function products_create()
{

}

function products_update()
{
    
}

function products_delete()
{
    
}


function productsBuilder($products): Array
{
    //Définition du tableu $output qui va nous servir à stocker la liste des produits
    $output = [];
    
    if (is_array($products))
    {
        foreach ($products as $product)
        {
            // On se base sur la clé primaire du produit (ID dans la BDD et)
            // identifier sous le nom "product_id" dans la requete (t1.id AS product_id)
            // pour définir le nombre réel de produits dans le tableau $output

            // Si l'index "ID du produit" n'existe pas dans le tableau $output,
            // alors on le créer et on lui affecte un tableau vide ( $output[2]= [])
            if (!isset($output[$product->product_id]))
            {
                $output [ $product->product_id ] = [];
            }
            // On reprend les propriétés du produit ($product) pour les ajouter à
            // notre nouveau tableau $output[2]
            $output[$product->product_id]['id'] = $product->product_id;
            $output[$product->product_id]['name'] = $product->product_name;
            $output[$product->product_id]['description'] = $product->product_description;
            $output[$product->product_id]['price'] = $product->product_price;
            $output[$product->product_id]['illustration'] = $product->product_illustration;
            
            // Pour la liste d'ingrédients, nous devons définir un tableau
            // Uniquement si celui-ci n'est pas déja définit
            if (!isset($output[$product->product_id]['ingredients'] ))
            {
                $output[$product->product_id]['ingredients'] = [];
            }

            // On ajoute les ingrédients dans le tableau
            array_push($output[$product->product_id]['ingredients'],
            ["name"=>$product->ingredient_name,"type"=>$product->ingredient_type]);
        }
    }
    
    return $output;
}