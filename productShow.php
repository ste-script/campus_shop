<div class="row justify-content-center mx-0">
    <div class="col-md-5 p-5">
        <?php echo $dbh->getImgFromId($prod['id']) . ">"; ?>
    </div>
    <div class="col-md-5 mt-5">
        <div class="display-5 fw-bolder h1"><?php echo $prod["nome"]; ?></div>
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
                    <label class="h3" for="quantity">Quantita: </label>
                    <input type="number" required="required" id="quantity" name="quantity" min="1" value="1" max="<?php echo $prod["quantita_disponibile"] . '"' . $disable ?>>
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
                <div class="modal-body">
                    <form id="addNewCategoryForm" action="./addNewCategory.php" method="POST"></form>
                    <form id="mainForm" action="#" method="POST" enctype="multipart/form-data"></form>
                    <!-- Name -->
                    <div class="row mb-2">
                        <div class="col-8">
                            <label class="ps-1 fs-5" for="nomeProd">Modifica Nome Prodotto</label>
                            <input type="text" class="form-control" name="nomeProd" id="nomeProd" required value="<?php echo $prod["nome"]; ?>"  form="mainForm">
                        </div>
                    </div>
                    <!-- Categories -->
                    <div class="row mb-2">
                        <div class="col-auto">
                            <div class="nav-item dropdown">
                                <a class="btn btn-secondary dropdown-toggle" role="button" data-bs-toggle="dropdown">
                                    Categorie
                                </a>
                                <div class="dropdown-menu ">
                                    <?php
                                    foreach ($dbh->getCategories() as $category) : ?>
                                        <div class="custom-control custom-checkbox fs-5 text-capitalize">
                                            <input type="checkbox" class="custom-control-input dropdown-checkbox ms-1" name="category[]" id="<?php echo $category["id"] ?>" value="<?php echo $category["id"]; ?>" form="mainForm" <?php if (in_array($category["id"], $dbh->getProductCategories($prod['id']))) {
                                                                                                                                                                                                                                        echo "checked";
                                                                                                                                                                                                                                    } ?>>
                                            <label class="custom-control-label" for="<?php echo $category["id"] ?>">
                                                <?php echo $category["nome"]; ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <a class="btn btn-secondary dropdown-toggle" role="button" data-bs-toggle="dropdown">
                                    Nuova Categoria
                                </a>
                                <div class="dropdown-menu p-3">
                                    <div class="form-group">
                                        <label class="ps-1 fs-5" for="categoryName">Inserisci Nome Categoria</label>
                                        <input type="text" class="form-control mb-1" id="categoryName" name="categoryName" placeholder="Nome" form="addNewCategoryForm">
                                    </div>
                                    <button type="submit" class="btn btn-primary" form="addNewCategoryForm">Sign in</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Description -->
                    <div class="row-auto mb-2">
                        <div class="col-auto">
                            <label class="ps-1 fs-5" for="descriptionProd">Modifica Descrizione Prodotto</label>
                            <textarea type="text" class="form-control" required name="descriptionProd" id="descriptionProd" form="mainForm"><?php echo $prod['descrizione'] ?></textarea>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <!-- Price -->
                        <div class="col-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="priceProd">€</label>
                                </div>
                                <input type="text" class="form-control" name="priceProd" id="priceProd" required value="<?php echo $prod["prezzo"]; ?>" form="mainForm">
                            </div>
                        </div>
                        <!-- Quantity -->
                        <div class="col-5">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="quantityProd">Quantità</label>
                                </div>
                                <input type="text" class="form-control" name="quantityProd" id="quantityProd" required value="<?php echo $prod["quantita_disponibile"]; ?>"  form="mainForm">
                            </div>
                        </div>
                    </div>
                    <!-- Image -->
                    <div class="row mb-2">
                        <div class="col-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text mb-1" for="imageProd">Immagine:</label>
                                <input type="file" name="imageProd" id="imageProd" accept="image/*" form="mainForm" value="<?php echo $prod["foto"]; ?>">
                            </div>
                        </div>
                    </div>
                    <!-- Visible -->
                    <div class="row mb-2">
                        <div class="col-5">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="visibilityProd">Visibile</label>
                                </div>
                                <input type="checkbox" class="form-check-input h1 m-0" value="1" name=" visibilityProd" id="visibilityProd" form="mainForm" <?php if ($prod['visibile'] == 1) {
                                                                                                                                                                echo "checked";
                                                                                                                                                            } ?>>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-success" value="Conferma" form="mainForm">
                </div>
            </div>
        </div>
    </div>
</div>