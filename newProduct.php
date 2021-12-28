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
                <form action="#" method="POST">
                    <div class="modal-body">
                        <!-- Name -->
                        <div class="row mb-2">
                            <div class="col-8">
                                <input type="text" class="form-control" required placeholder="Nome Prodotto" name="nomeProd" id="nomeProd">
                            </div>
                        </div>
                        <!-- Categories -->
                        <div class="row mb-2">
                            <div class="col-auto">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Categorie</div>
                                    </div>
                                    <input type="text" class="form-control" required name="categoriesProd" id="categoriesProd" placeholder="Categorie Prodotto">
                                </div>
                            </div>
                        </div>
                        <!-- Description -->
                        <div class="row-auto mb-2">
                            <div class="col-auto">
                                <textarea type="text" class="form-control" required placeholder="Descrizione Prodotto" name="descriptionProd" id="descriptionProd"></textarea>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <!-- Price -->
                            <div class="col-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">€</div>
                                    </div>
                                    <input type="text" class="form-control" required name="priceProd" id="priceProd">
                                </div>
                            </div>
                            <!-- Quantity -->
                            <div class="col-5">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Quantità</div>
                                    </div>
                                    <input type="text" class="form-control" required name="quantityProd" id="quantityProd">
                                </div>
                            </div>
                        </div>
                        <!-- Image -->
                        <div class="row mb-2">
                            <div class="col-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text mb-1">Immagine:</div>
                                    <input type="file" id="imageProd" accept="image/*">
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
                                    <input type="checkbox" class="form-check-input h1 m-0" name=" visibilityProd" id="visibilityProd">
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