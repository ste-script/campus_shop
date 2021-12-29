<div class="col-5 mt-4 ms-3 ">
    <button data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn btn-success fs-5 ">Aggiungi Prodotto</button>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Nuovo Prodotto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addNewCategoryForm" action="./addNewCategory.php" method="POST"></form>
                <form id="mainForm" action="#" method="POST" enctype="multipart/form-data"></form>
                    <div class="modal-body">
                        <!-- Name -->
                        <div class="row mb-2">
                            <div class="col-8">
                                <input type="text" class="form-control" required placeholder="Nome Prodotto" name="nomeProd" id="nomeProd" form="mainForm">
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
                                                <input type="checkbox" class="custom-control-input dropdown-checkbox ms-1" name="category[]" value="<?php echo $category["id"]; ?>" form="mainForm">
                                                <label class="custom-control-label" for="category <?php echo $category["id"] ?>">
                                                    <?php echo $category["nome"]; ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <a class="btn btn-secondary dropdown-toggle" role="button" data-bs-toggle="dropdown">
                                        Nuova Categoria
                                    </a>
                                    <div class="dropdown-menu ">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="categoryName" name="categoryName" placeholder="Nome" form="addNewCategoryForm">
                                        </div>
                                        <button type="submit" class="btn btn-primary" form="addNewCategoryForm">Sign in</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Description -->
                        <div class="row-auto mb-2">
                            <div class="col-auto">
                                <textarea type="text" class="form-control" required placeholder="Descrizione Prodotto" name="descriptionProd" id="descriptionProd" form="mainForm"></textarea>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <!-- Price -->
                            <div class="col-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">€</div>
                                    </div>
                                    <input type="text" class="form-control" required name="priceProd" id="priceProd" form="mainForm">
                                </div>
                            </div>
                            <!-- Quantity -->
                            <div class="col-5">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Quantità</div>
                                    </div>
                                    <input type="text" class="form-control" required name="quantityProd" id="quantityProd" form="mainForm">
                                </div>
                            </div>
                        </div>
                        <!-- Image -->
                        <div class="row mb-2">
                            <div class="col-auto">
                                <div class="input-group-prepend">
                                    <div class="input-group-text mb-1">Immagine: (1024x1024 px .jpg)</div>
                                    <input type="file" name="imageProd" accept="image/*" form="mainForm">
                                </div>
                            </div>
                        </div>
                        <!-- Visible -->
                        <div class="row mb-2">
                            <div class="col-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Visibile</div>
                                    </div>
                                    <link rel="stylesheet" href="./css/style.css">
                                    <input type="checkbox" class="form-check-input m-0 big-checkbox " name=" visibilityProd" id="visibilityProd" form="mainForm">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" value="Conferma" form="mainForm">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>