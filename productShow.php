<div class="row justify-content-center mx-0">
    <div class="col-md-5 p-5">
        <?php echo $dbh->getImgFromId($prod['id']) . ">"; ?>
    </div>
    <div class="col-md-5 mt-5">
        <h1 class="display-5 fw-bolder"><?php echo $prod["nome"]; ?></h1>
        <div class="h3">
            <?php foreach ($dbh->getProductCategories($prod['id']) as $categoryId) : ?>
                <a class="text-capitalize text-decoration-none text-muted" href="categoryGrid.php?categoryId=<?php echo $categoryId; ?>"><?php echo $dbh->getCategoryName($categoryId); ?> </a>
            <?php endforeach; ?>
        </div>
        <a class="h3 text-capitalize text-decoration-none text-muted" href="vendorGrid.php?vendorId=<?php echo $prod['id_venditore']; ?>"><?php echo $dbh->getVendorName($prod['id_venditore']); ?></a>

        <p class="lead my-2"><?php echo $prod['descrizione'] ?></p>
        <hr class="singleline">
        <div class="row">
            <form action="addorder.php" method="POST">
                <div class="my-3">
                    <span class="h3">Quantita: </span>
                    <input type="number" required="required" name="quantity" min="1" value="1" max="<?php echo $prod["quantita_disponibile"] . '"' . $disable ?>>
                    <span class=" h3 fw-bold ms-5">€ <?php echo $prod['prezzo']; ?></span>
                </div>
                <div class="col-xs-2 my-2">
                    <?php echo $buttonType ?>
                </div>
                <input type="hidden" value="<?php echo  $_GET["productId"]; ?>" name="productId">
            </form>
        </div>
        <?php
        if (isset($_GET["ordered"])) {
            echo "<p class='text-success'> Prodotto aggiunto al carrello </p>";
        }
        ?>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modifica <?php echo $prod["nome"]; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <!-- Name -->
                        <div class="row mb-2">
                            <div class="col-8">
                                <input type="text" class="form-control" required value="<?php echo $prod["nome"]; ?>" name="nomeProd" id="nomeProd">
                            </div>
                        </div>
                        <!-- Categories -->
                        <div class="row mb-2">
                            <div class="col-auto">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Categorie</div>
                                    </div>
                                    <input type="text" class="form-control" required name="categoriesProd" id="categoriesProd" value="<?php
                                                                                                                                        foreach ($dbh->getProductCategories($prod['id']) as $categoryId) {
                                                                                                                                            echo ucfirst($dbh->getCategoryName($categoryId)) . ", ";
                                                                                                                                        } ?>">
                                </div>
                            </div>
                        </div>
                        <!-- Description -->
                        <div class="row-auto mb-2">
                            <div class="col-auto">
                                <textarea type="text" class="form-control" required name="descriptionProd" id="descriptionProd"><?php echo $prod['descrizione'] ?></textarea>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <!-- Price -->
                            <div class="col-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">€</div>
                                    </div>
                                    <input type="text" class="form-control" required value="<?php echo $prod["prezzo"]; ?>" name="priceProd" id="priceProd">
                                </div>
                            </div>
                            <!-- Quantity -->
                            <div class="col-5">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Quantità</div>
                                    </div>
                                    <input type="text" class="form-control" required value="<?php echo $prod["quantita_disponibile"]; ?>" name="quantityProd" id="quantityProd">
                                </div>
                            </div>
                        </div>
                        <!-- Image -->
                        <div class="row mb-2">
                            <div class="col-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text mb-1">Immagine:</div>
                                    <input type="file" name="imageProd" accept="image/*">
                                </div>
                            </div>
                        </div>
                        <!-- Visible -->
                        <div class="row mb-2">
                            <div class="col-5">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Visibile</div>
                                    </div>
                                    <input type="checkbox" class="form-check-input h1 m-0" value="1" name=" visibilityProd" id="visibilityProd" <?php if($prod['visibile']==1){echo "checked";}?>>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" value="Conferma">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>