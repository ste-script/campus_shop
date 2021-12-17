<?php
require_once("./bootstrap.php");

$templateParams["titolo"] = "Campus Shop - Home";
if (isUserLoggedIn()) {

    $templateParams["headerMenu"] = [
        ['link' => '#', 'nome' => 'Cart'],
        ['link' => '#', 'nome' => 'Card'],
        ['link' => '#', 'nome' => 'Order'],
        ['link' => 'client.php', 'nome' => 'Account'],
        ['link' => 'logout.php', 'nome' => 'Logout']
    ];
} else {
    $templateParams["headerMenu"] = [
        ['link' => '#', 'nome' => 'Cart'],
        ['link' => '#', 'nome' => 'Card'],
        ['link' => '#', 'nome' => 'Order'],
        ['link' => 'login.php', 'nome' => 'Login']
    ];
}
include('./layouts/headerCostumer.php');

$categories = $dbh->getCategories();
for ($categoryIndex = 0; $categoryIndex < 4 && $categoryIndex < count($categories); $categoryIndex++) {
    $templateParams["carouselTitle"] = $categories[$categoryIndex]["nome"];
    $templateParams["products"] = $dbh->getProductsFromCategories($templateParams["carouselTitle"]);
    include('.\cliente\carousel.php');
}
if (isUserLoggedIn()) {
    $templateParams["carouselTitle"] = "Carrello";
    $templateParams["products"] = $dbh->getCartProductsByClientId($_SESSION["userId"]);
    if (!empty($templateParams["products"])) {
        include('.\cliente\carousel.php');
    }
}
$templateParams["gridTitle"] = "Tutti i prodotti";
$templateParams["products"] = $dbh->showProducts(50);
if (!empty($templateParams["products"])) {
    include('.\cliente\productgrid.php');
}

include('./layouts/footer.php');
