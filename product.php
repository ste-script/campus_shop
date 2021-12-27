<?php
require('bootstrap.php');
if (!isset($_GET["productId"]) || !is_numeric($_GET["productId"])) {
    header("Location: index.php");
    exit;
}
if (isVendorLoggedIn()) {
    $buttonType = '<input type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn btn-success" value="Modifica Prodotto">';
    $disable = "disabled";
} else {
    $buttonType = '<input type="submit" class="btn btn-primary" value="Aggiungi al Carrello">';
    $disable = "";
}

if (isset($_POST["nomeProd"]) && is_string($_POST["nomeProd"]) && 
    isset($_POST["categoriesProd"]) && is_string($_POST["categoriesProd"]) && 
    isset($_POST["descriptionProd"]) && is_string($_POST["descriptionProd"]) && 
    isset($_POST["priceProd"]) && is_numeric($_POST["priceProd"]) && 
    isset($_POST["quantityProd"]) && is_numeric($_POST["quantityProd"]) && 
    isset($_POST["imageProd"]) && is_string($_POST["imageProd"]) && 
    isset($_POST["visibilityProd"]) && is_bool($_POST["visibilityProd"])) 
    {
        $dbh->updateProductFromId($_GET["productId"], $_POST["nomeProd"], $_POST["priceProd"], $_POST["quantityProd"], $_POST["visibilityProd"], $_POST["imageProd"], $_POST["quantityProd"]);
}

$prod = $dbh->getProductFromId($_GET["productId"]);
$templateParams["titolo"] = "Campus Shop - " . $prod["nome"];

include('./layouts/header.php');
include('./productShow.php');
include('./layouts/footer.php');
