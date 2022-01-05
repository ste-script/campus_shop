<?php
require_once("./bootstrap.php");
if (!isVendorLoggedIn()) {
    header("Location: index.php");
    exit;
}
$templateParams["titolo"] = "Campus Shop - Home";
include("./layouts/header.php");


$templateParams['products'] = $dbh->getProductsFromVendorId($_SESSION["userId"]);
$templateParams['products'] ? $templateParams['carouselTitle'] = "Prodotti": $templateParams['gridTitle'] = "Nessun Prodotto";

if (!empty($templateParams['products'])) {
    include('.\cliente\carousel.php');
}
else{
    require('./newProduct.php');
    include('./cliente/productGrid.php');
}


include("./layouts/footer.php");
