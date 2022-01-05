<?php
    require_once("./bootstrap.php");

    $categoryName= $dbh->getCategoryName($_GET["categoryId"]);
    $templateParams["titolo"] = "Campus Shop - ". ucfirst($categoryName);
    $templateParams['gridTitle'] = ucfirst($categoryName);
    $templateParams['products'] = $dbh->getProductsFromCategories($_GET["categoryId"]);

    require('./layouts/header.php');
    
    if (!empty($templateParams['products'])) {
        include('./cliente/productgrid.php');
    }
    
    require('./layouts/footer.php');

?>