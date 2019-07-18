<?php
/**
 * Fichier qui gère les pages de securité
 */
/**
 * login
 */
function security_login()
{
    $pageTitle = "Contactez nous";
    // Verifie si l'utilisateur est deja identifié
    if (isset($_SESSION['user']['id']) && !empty($_SESSION['user']['id'])) 
    {
        redirect(url("account"));
    }
    if ($_SERVER['REQUEST_METHOD'] === "POST")
    {
        include_once "../src/models/security.php";

        // Définition du tableau d'erreurs
        $isValid = true;
    
        // Récup des données
        $email          = isset($_POST['email']) ? trim(htmlentities($_POST['email'])) : null;
        $password_text  = isset($_POST['password']) ? $_POST['password'] : null;
    
        // Est ce que un utilisateur correspond à l'adresse $email
        $user = getUserByEmail($email, false);

        // Si $user est un tableau vide, => L'UTILISATEUR N'EST PAS ENREGISTRE DANS LA BDD
        if (!$user) {
            $isValid = false;
        }
    
        // Si l'utilisateur a ete trouvé dans la BDD
        // On compare le mot de passe saisi et celui de la BDD
        if ($isValid) 
        {
            if (password_verify( $password_text, $user['pwd'] )) 
            {
                // Recupération du panier utilisateur a partir du numero de session
                // Ce code permet d'associer un panier à un client qui s'identifie après 
                // que celui-ci ait créer le panier en étant anonyme
                //$order = getOrderByUser(session_id());

                // Suppression du MDP du resultat de la requete
                unset($user['pwd']);
                // Ajouter les informations utilisateur dans la $_SESSION
                $_SESSION['user'] = $user;

                // Associe l'ID utilisateur à sa commande en cours
                // Redirige l'utilisateur
                redirect();
            }
            else {
                $isValid = false;
            }
        }
    
        if (!$isValid) {
            setFlashbag("danger", "oops, mauvais identifiants....");
        }
    }
    include_once "../src/views/security/login.php";
}
/**
 * register
 */
function security_register()
{
    GLOBAL $regex;
    $pageTitle = "Inscription";
    
    // Verifie si l'utilisateur est deja identifié
    if (isset($_SESSION['user']['id']) && !empty($_SESSION['user']['id'])) 
    {
        redirect( url("account") );
    }
    if ($_SERVER['REQUEST_METHOD'] === "POST")
    {
        include_once "../src/models/security.php";

        // Définition du tableau d'erreurs
        $errors = [];

        // Récupération des données 
        $firstname      = isset($_POST['firstname']) ? trim(htmlentities($_POST['firstname'])) : null;
        $lastname       = isset($_POST['lastname']) ? trim(htmlentities($_POST['lastname'])) : null;
        $email          = isset($_POST['email']) ? trim(htmlentities($_POST['email'])) : null;
        $terms          = isset($_POST['terms_of_sales']) ? true : false;
        $password_text  = isset($_POST['password']) ? $_POST['password'] : null;
        $password_hash  = password_hash($password_text, PASSWORD_DEFAULT);
        
        // Controle des données

        // Controle du prenom
        if (!preg_match($regex['names'],$firstname))
        {
            $errors['firstname'] = "Votre prénom n'est pas valide.";
        }

        // Controle du nom
        if (!preg_match($regex['names'],$lastname))
        {
            $errors['lastname'] = "Votre nom n'est pas valide.";
        }

        // Controle de l'adresse email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $errors['email'] = "Votre email n'est pas valide";
        }

        // Controle des CGV
        if (!$terms)
        {
            $errors['terms_of_sales'] = "Vous devez accepter les Conditions de ventes";
        }

        // Verification de l'unicité de l'utilisateur
        $user = getUserByEmail($email);
        // Si $user contient au moins un résultat, on stop le processus d'inscription
        if (!empty($user)) 
        {
            $errors['user'] = "Un utilisateur est déjà enregistré avec cette adresse email.";
        }
        // Enregistrement des données dans la BDD
        if (empty($errors)) 
        {
            $user = addUser([
                "firstname" => $firstname,
                "lastname" => $lastname,
                "email" => $email,
                "password" => $password_hash
            ]);
            // Si la requete est un succès
            if ($user) { // $user === true
                redirect(url("login"));
            }
            else {
                setFlashbag("danger", "les données n'ont pas été enregistrées dans la BDD !");
            }
        }
        else {
            setFlashbag("warning", "oops, erreur sur le form !");
        }
    }
    include_once "../src/views/security/register.php";
}
/**
 * forgotten_password
 */
function security_forgotten_password()
{
    $pageTitle = "Récupération du mot de passe";

    // Si utilisateur deja identifier => redirection vers /mon-compte
    if (isset($_SESSION['user']['id']) && !empty($_SESSION['user']['id'])) 
    {
        redirect(url("account"));
    }
    
    if ($_SERVER['REQUEST_METHOD'] === "POST")
    {
        include_once "../src/models/security.php";
        // Définition des erreurs
        $errors = [];

        // Récup des données
        $email = isset($_POST['email']) ? trim(htmlentities($_POST['email'])) : null;

        // Verification de l'unicité de l'utilisateur
        $user = getUserByEmail($email);

        if (!$user)
        {
            $errors['user'] = "L'utilisateur $email n'existe pas.";
        }

        if (empty($errors))
        {
            // Génération du token
            $pwd_token = md5(uniqid().$email);

            // Injection du token
            $q = addPwdToken($pwd_token, $user['id']);

            // Message de confirmation
            if ($q)
            {
                // messsage ok
                
                // Création du message (email)
                $mail_message = "Modier votre MDP en clicquant sur le lien suivant :<br>\n";
                $mail_message .= url("renew_password",true)."?token=".$pwd_token;
                // Envoi email

                mail($email,"Récupération de mot de passe WebPizza",$mail_message);
            }
            else
            {
                // Message ko
            }
        }
    }

    // Affichage du formulaire (email)
    include_once "../src/views/security/forgotten_password.php";
}


function security_renew_password() 
{
    // Inclusion de la dépendance du model sécurity
    include_once "../src/models/security.php";
    $pageTitle = "Modification du mot de passe";
    // Définition du tableau d'erreurs
    $errors = [];
    // Recup du token
    $token = isset($_GET['token']) ? $_GET['token'] : null;
    // Vérification du token
    if ($token == null) 
    {
        $errors['token'] = "Bad token";
    }
    // Si le token est OK (pas d'erreur)
    if (empty($errors))
    {
        // On tente de récupérer les données de l'utilisateur à l'origine de la demande de renouvellement du mot de passe
        $user = getUserByPwdToken($token);
        // Si la requête retourne "false", l'utilisateur n'a pas ete trouvé dans la BDD (mauvais token ou token effacé de la BDD)
        if (!$user) 
        {
            $errors['token'] = "User by token not found";
        }
        // Si non ($user OK), on test le délais de validité du token
        elseif (($user['pwd_token_expire'] - time()) < 0)
        {
            $errors['token'] = "Token expired";
        }
    }
    // Si le token est OK (pas d'erreur)
    if (empty($errors) && $_SERVER['REQUEST_METHOD'] === "POST")
    {
        // Récupération des données 
        $password_text      = isset($_POST['password']) ? $_POST['password'] : null;
        $password_confirm   = isset($_POST['password_confirmation']) ? $_POST['password_confirmation'] : null;
        $password_hash      = password_hash($password_text, PASSWORD_DEFAULT);        
        // Controle du mot de passe
        if ($password_text != $password_confirm) 
        {
            $errors['password'] = "Les mots de passe ne sont pas identique";
        }
        if (empty($errors))
        {
            // Modification de la BDD
            $query = renewPassword([
                "id" => $user['id'],
                "password" => $password_hash
            ]);
            // redirection de l'utilisateur
            redirect(url("login"));
        }
    }
    if (!empty($errors))
    {
        include_once "../src/views/security/renew_password_error.php";
        return;
    }
    include_once "../src/views/security/renew_password.php";
}


// Traitement des données du formulaire
    
    // Controle des données
    // Verification de l'utilisateur
    // Si OK => Process (token + email)
    // Si KO => flashbag message d'erreur
/**
 * Deconnexion utilisateur
 */
function security_logout()
{
    unset($_SESSION);
    // Deconnexion de l'utilisateur
    session_destroy();
    // redirection vers la page d'accueil
    redirect();
}