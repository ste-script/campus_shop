<?php
require_once("./bootstrap.php");
if (!isVendorLoggedIn()) {
    header("Location: index.php");
    exit;
}
$templateParams["titolo"] = "Campus Shop - Home";
include("./layouts/header.php");

$templateParams['products'] = $dbh->getProductsFromVendorId($_SESSION["userId"]);
$templateParams['products'] ? $templateParams['carouselTitle'] = "Prodotti" : $templateParams['gridTitle'] = "Nessun Prodotto";

if (
    isset($_POST["nomeProd"]) && is_string($_POST["nomeProd"]) &&
    isset($_POST["descriptionProd"]) && is_string($_POST["descriptionProd"]) &&
    isset($_POST["priceProd"]) && is_numeric($_POST["priceProd"]) &&
    isset($_POST["quantityProd"]) && is_numeric($_POST["quantityProd"]) &&
    isset($_FILES["imageProd"]) && is_string($_FILES["imageProd"]["tmp_name"])
) {
    isset($_POST["visibilityProd"]) ? $_POST["visibilityProd"] = 1 : $_POST["visibilityProd"] = 0;

    $temp = basename($_FILES["imageProd"]['name']);
    $ext = strtolower(substr($temp, strrpos($temp, '.') + 1));
    if (!(($ext == "jpg" || $ext == "png") && ($_FILES["imageProd"]["type"] == "image/jpeg" || $_FILES["imageProd"]["type"] == "image/png") &&
        ($_FILES["imageProd"]["size"] < 2120000))) {
        header("Location: vendorProducts.php");
        exit;
    } else {
        do {
            $fileName = round(microtime(true)) . $temp;
        } while (file_exists(UPLOAD_DIR . $fileName));
        if (move_uploaded_file($_FILES["imageProd"]["tmp_name"], UPLOAD_DIR . $fileName)) {
            $prodId = $dbh->insertNewProduct(strtoupper($_POST["nomeProd"]), $_POST["priceProd"], $_POST["quantityProd"], $_POST["visibilityProd"], $fileName, $_POST["descriptionProd"], $_SESSION["userId"]);
        }
    }
    if (isset($_POST["category"])) {
        $dbh->manageCategory($prodId, $_POST["category"]);
    }
}

if (!empty($templateParams['products'])) {
    include('./cliente/carousel.php');
} else {
    require('./newProduct.php');
    include('./cliente/productGrid.php');
}


include("./layouts/footer.php");
