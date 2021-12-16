<?php
require_once("./bootstrap.php");

$templateParams["titolo"] = "Campus Shop";
include('./layouts/headerCostumer.php');

$categories = $dbh->getCategories();
for ($categoryIndex = 0; $categoryIndex < 4 && $categoryIndex < count($categories); $categoryIndex++) {
    $category = $categories[$categoryIndex];
    include('.\cliente\carousel.php');
}


include('./layouts/footer.php');
