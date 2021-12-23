<?php
require_once("./bootstrap.php");
if (!isVendorLoggedIn()) {
    header("Location: index.php");
    exit;
}
$templateParams["titolo"] = "Campus Shop - Home";
include("./layouts/headerCostumer.php");



$templateParams['carouselTitle'] = 'Prodotti';
$templateParams['products'] = $dbh->getProductsFromVendorId($_SESSION["userId"]);
if (!empty($templateParams['products'])) {
    include('.\cliente\carousel.php');
}


include("./layouts/footer.php");
