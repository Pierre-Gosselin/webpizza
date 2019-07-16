<?php
    include_once "../src/views/layout/header.php";
?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <form method="POST">
            
                <label for="email">Votre identifiant :</label>
                <input type="text" name="email" id="email">

                <label for="password">Votre mot de passe :</label>
                <input type="password" name="password" id="password">

                <button type="submit">Connexion</button>
            
            </form>
        </div>
    </div>

</div>

<?php
    include_once "../src/views/layout/footer.php";
?>
