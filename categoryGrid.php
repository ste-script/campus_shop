<?php
    require_once("./bootstrap.php");

    $templateParams["titolo"] = "Campus Shop - ". ucfirst($_GET["categoryName"]);
    $templateParams['gridTitle'] = ucfirst($_GET["categoryName"]);
    $templateParams['products'] = $dbh->getProductsFromCategories($_GET["categoryName"]);

    require('./layouts/headerCostumer.php');
    
    if (!empty($templateParams['products'])) {
        include('.\cliente\productgrid.php');
    }
    
    require('./layouts/footer.php');

?>