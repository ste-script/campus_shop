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
                            <label class="ps-1 fs-5" for="nomeProd">Inserisci Nome Prodotto</label>
                            <input type="text" class="form-control" required name="nomeProd" id="nomeProd" form="mainForm">
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
                                            <input type="checkbox" class="custom-control-input dropdown-checkbox ms-1" id="category <?php echo $category["id"] ?>" name="category[]" value="<?php echo $category["id"]; ?>" form="mainForm">
                                            <label class="custom-control-label" for="category <?php echo $category["id"] ?>">
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
                            <label class="ps-1 fs-5" for="descriptionProd"> Inserisci Descrizione Prodotto</label>
                            <textarea type="text" class="form-control" required name="descriptionProd" id="descriptionProd" form="mainForm"></textarea>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <!-- Price -->
                        <div class="col-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="priceProd">€</label>
                                </div>
                                <input type="text" class="form-control" required name="priceProd" id="priceProd" form="mainForm">
                            </div>
                        </div>
                        <!-- Quantity -->
                        <div class="col-5">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="quantityProd">Quantità</label>
                                </div>
                                <input type="text" class="form-control" required name="quantityProd" id="quantityProd" form="mainForm">
                            </div>
                        </div>
                    </div>
                    <!-- Image -->
                    <div class="row mb-2">
                        <div class="col-auto">
                            <div class="input-group-prepend">
                                <label class="input-group-text mb-1" for="imageProd">Immagine: (1024x1024px *.jpg)</label>
                                <input type="file" id="imageProd" name="imageProd" accept="image/*" form="mainForm">
                            </div>
                        </div>
                    </div>
                    <!-- Visible -->
                    <div class="row mb-2">
                        <div class="col-12">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="visibilityProd">Visibile</labe>
                                </div>
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