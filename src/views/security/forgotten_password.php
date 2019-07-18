<?php
    include_once "../src/views/layout/header.php";
?>

<div class="container">
    <div class="row">
        <div class="col-4 offset-4">

            <h2><?= $pageTitle ?></h2>

            <form method="POST" class="mb-4 mt-4">
            
                <div class="form-group">
                    <label for="login">Identifiant</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>

                <button type="submit" class="btn btn-success btn-block">Modifier mon mot de passe</button>
            </form>
            <div class="mb-4">
                <a href="<?= url("login") ?>">Je me connecte</a><br>
            </div>            
        </div>
    </div>

</div>

<?php
    include_once "../src/views/layout/footer.php";
?>
