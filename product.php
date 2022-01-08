<?php
require('bootstrap.php');

if (!isset($_GET["productId"]) || !is_numeric($_GET["productId"])) {
    header("Location: index.php");
    exit;
}
if (empty($dbh->getProductFromId($_GET["productId"]))) {
    header("Location: index.php");
    exit;
}

//carichiamo il prodotto
$oldProd = $dbh->getProductFromId($_GET["productId"]);
//definiamo gli elementi disponibili a seconda di quale utente sta navigando
if (isVendorLoggedIn() && $oldProd['id_venditore'] == $_SESSION['userId']) {
    $buttonType = '<input type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn btn-success" value="Modifica Prodotto">';
} elseif (isVendorLoggedIn()) {
    $buttonType = "";
} else {
    $buttonType = '<input type="submit" class="btn btn-primary" value="Aggiungi al Carrello">';
}


//in caso di product update da parte del vendor
if (
    isset($_POST["nomeProd"]) && is_string($_POST["nomeProd"]) &&
    isset($_POST["descriptionProd"]) && is_string($_POST["descriptionProd"]) &&
    isset($_POST["priceProd"]) && is_numeric($_POST["priceProd"]) &&
    isset($_POST["quantityProd"]) && is_numeric($_POST["quantityProd"])
) {
    isset($_POST["visibilityProd"]) ? $_POST["visibilityProd"] = 1 : $_POST["visibilityProd"] = 0;
    isset($_POST["category"]) ? $dbh->manageCategory($_GET["productId"], $_POST["category"]) : $dbh->deleteAllCategories($_GET["productId"]);
    $filePath = basename($_FILES["imageProd"]['name']);
    if (isset($_FILES["imageProd"]["tmp_name"]) && move_uploaded_file($_FILES["imageProd"]["tmp_name"], "./img/" . $filePath)) {
        $dbh->updateProductFromId($_GET["productId"], strtoupper($_POST["nomeProd"]), $_POST["priceProd"], $_POST["quantityProd"], $_POST["visibilityProd"], $filePath, $_POST["descriptionProd"]);
    } else {
        $dbh->updateProductFromId($_GET["productId"], strtoupper($_POST["nomeProd"]), $_POST["priceProd"], $_POST["quantityProd"], $_POST["visibilityProd"], $oldProd["foto"], $_POST["descriptionProd"]);
    }
}
// carichiamo il nuovo prodotto aggiornato
$prod = $dbh->getProductFromId($_GET["productId"]);
//definiamo gli elementi disponibili a seconda di quale utente sta navigando
if (isVendorLoggedIn() && $prod['id_venditore'] == $_SESSION['userId']) {
    $quantityLabel = '<label class="h3" for="quantity">Quantita: </label>';
    $quantityForm = '<input class="col-2 text-center" type="text" id="quantity" name="quantity" value="' . $prod["quantita_disponibile"] . '" disabled>';
} elseif (isVendorLoggedIn()) {
    $quantityForm = '';
    $quantityLabel = '';
} else {
    $quantityLabel = '<label class="h3" for="quantity">Quantita: </label>';
    $quantityForm = '<input type="number" required id="quantity" name="quantity" onchange="priceCalculator(this,' . $prod["prezzo"] . ')" onkeyup="priceCalculator(this,' . $prod["prezzo"] . ')" min="1" value="1" max="' . $prod["quantita_disponibile"] . '">';
}
//degfiniamo il titolo della pagina
$templateParams["titolo"] = "Campus Shop - " . $prod["nome"];
//includiamo i layout
include('./layouts/header.php');
include('./productShow.php');
include('./layouts/footer.php');
