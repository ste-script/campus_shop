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

$oldProd = $dbh->getProductFromId($_GET["productId"]);

if (isVendorLoggedIn() && $oldProd['id_venditore'] == $_SESSION['userId']) {
    $buttonType = '<input type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn btn-success" value="Modifica Prodotto">';
} elseif (isVendorLoggedIn()) {
    $buttonType = "";
} else {
    $buttonType = '<input type="submit" class="btn btn-primary" value="Aggiungi al Carrello">';
}



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

$prod = $dbh->getProductFromId($_GET["productId"]);
if (isVendorLoggedIn()) {
    $quantityForm = '<input class="col-2 text-center"type="text" id="quantity" name="quantity" value="' . $prod["quantita_disponibile"] . '" disabled>';
} else {
    $quantityForm = '<input type="number" required id="quantity" name="quantity" min="1" value="1" max="' . $prod["quantita_disponibile"] . '">';
}
$templateParams["titolo"] = "Campus Shop - " . $prod["nome"];

include('./layouts/header.php');
include('./productShow.php');
include('./layouts/footer.php');