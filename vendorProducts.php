<?php
require_once("./bootstrap.php");

$title = "I Tuoi Prodotti";
$templateParams["titolo"] = "Campus Shop - " . $title;
$templateParams['gridTitle'] = $title;

if (
    isset($_POST["nomeProd"]) && is_string($_POST["nomeProd"]) &&
    isset($_POST["categoriesProd"]) && is_string($_POST["categoriesProd"]) &&
    isset($_POST["descriptionProd"]) && is_string($_POST["descriptionProd"]) &&
    isset($_POST["priceProd"]) && is_numeric($_POST["priceProd"]) &&
    isset($_POST["quantityProd"]) && is_numeric($_POST["quantityProd"]) &&
    isset($_FILES["imageProd"]) && is_string($_FILES["imageProd"]["tmp_name"])
) {

    isset($_POST["visibilityProd"]) ? $_POST["visibilityProd"] = 1 : $_POST["visibilityProd"] = 0;
    $filePath = basename($_FILES["imageProd"]['name']);
    if (move_uploaded_file($_FILES["imageProd"]["tmp_name"], "./img/" . $filePath)) {
        $dbh->insertNewProduct($_POST["nomeProd"], $_POST["priceProd"], $_POST["quantityProd"], $_POST["visibilityProd"], $filePath, $_POST["descriptionProd"], $_SESSION["userId"]);
    }
}

require('./layouts/header.php');
require('./newProduct.php');

$templateParams['products'] = $dbh->getProductsFromVendorId($_GET["vendorId"]);
if (!empty($templateParams['products'])) {
    include('.\cliente\productgrid.php');
}

require('./layouts/footer.php');
