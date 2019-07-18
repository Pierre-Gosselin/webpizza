<?php include_once "../src/views/layout/header.php" ?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h2>Mon panier</h2>

            <?php if ($products) : ?>
                On affiche la liste des produits

                <table class="table">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Produit</th>
                            <th>Quantité</th>
                            <th>Prix Unitaire</th>
                            <th>Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product) : ?>
                            <tr>
                                <th><img src="assets/images/<?= $product['illustration'] ?>"></th>
                                <th>
                                    <?= $product['name'] ?>
                                    <div>
                                        <?= $product['description'] ?>
                                    </div>
                                </th>
                                <th>
                                    <a href="#">-</a>
                                    <?= $product['quantity'] ?>
                                    <a href="#">+</a>
                                </th>
                                <th><?= $product['price'] ?></th>
                                <th><?= $product['amount'] ?></th>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>               
                </table>
            <?php else: ?>
                <div class="alert alert-waring">
                    Votre panier est vide
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include_once "../src/views/layout/footer.php" ?>