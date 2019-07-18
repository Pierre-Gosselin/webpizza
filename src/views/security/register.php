<?php
    include_once "../src/views/layout/header.php";
?>

<div class="container">
    <div class="row">
        <div class="col-4 offset-4">

            <h2><?= $pageTitle ?></h2>

            <form method="POST" class="mb-4 mt-4" novalidate>
            
                <div class="form-group">
                    <label for="firstname">Prenom</label>
                    <input type="text" class="form-control" id="firstname" name="firstname">
                </div>

                <div class="form-group">
                    <label for="lastname">Nom</label>
                    <input type="text" class="form-control" id="lastname" name="lastname">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>

                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" name="terms_of_sales" id="terms_of_sales">
                    <label class="form-check-label" for="terms_of_sales">J'accèpte les <span>conditions</span> de vente</label>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Inscription</button>
            </form>
            <div class="mb-4">
                <a href="<?= url("login") ?>">J'ai déjà un compte</a><br>
            </div>            
        </div>
    </div>

</div>

<?php
    include_once "../src/views/layout/footer.php";
?>
