<?php
    require_once("./bootstrap.php");
    $templateParams["titolo"] = "Campus Shop - ". ucfirst($_GET["vendorName"]);
    $templateParams['gridTitle'] = ucfirst($_GET["vendorName"]);
    $templateParams['products'] = $dbh->getProductsFromVendor($_GET["vendorName"]);

    require('./layouts/headerCostumer.php');
    
    if (!empty($templateParams['products'])) {
        include('.\cliente\productgrid.php');
    }
    
    require('./layouts/footer.php');

?>