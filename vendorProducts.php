<?php
    require_once("./bootstrap.php");

    $title= "I Tuoi Prodotti";
    $templateParams["titolo"] = "Campus Shop - ". $title;
    $templateParams['gridTitle'] = $title;
    $templateParams['products'] = $dbh->getProductsFromVendorId($_GET["vendorId"]);

    require('./layouts/header.php');
    
    if (!empty($templateParams['products'])) {
        include('.\cliente\productgrid.php');
    }
    
    require('./layouts/footer.php');
