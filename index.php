<?php
require_once("./bootstrap.php");
if (isVendorLoggedIn()) {
    header("Location: vendor.php");
    exit;
}
$templateParams["titolo"] = "Campus Shop - Home";
include("./layouts/header.php");
?>
<div class="text-center my-5 h1">Campus Shop</div>
<?php
$categories = $dbh->getCategories();
for ($categoryIndex = 0; $categoryIndex < 4 && $categoryIndex < count($categories); $categoryIndex++) {
    $templateParams['carouselTitle'] = $categories[$categoryIndex]['nome'];
    $templateParams['products'] = $dbh->getProductsFromCategories( $categories[$categoryIndex]['id']);
    include('.\cliente\carousel.php');
}
if (isUserLoggedIn()) {
    $templateParams['carouselTitle'] = 'Carrello';
    $templateParams['products'] = $dbh->getCartProductsByClientId($_SESSION['userId']);
    if (!empty($templateParams['products'])) {
        include('.\cliente\carousel.php');
    }
}


$templateParams['gridTitle'] = 'Tutti i prodotti';
$templateParams['products'] = $dbh->showProducts(50);
if (!empty($templateParams['products'])) {
    include('.\cliente\productgrid.php');
}

include("./layouts/footer.php");
