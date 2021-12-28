<?php
    require_once("./bootstrap.php");

    $title= "I Tuoi Prodotti";
    $templateParams["titolo"] = "Campus Shop - ". $title;
    $templateParams['gridTitle'] = $title;
    $templateParams['products'] = $dbh->getProductsFromVendorId($_GET["vendorId"]);

    if (isset($_POST["nomeProd"]) && is_string($_POST["nomeProd"]) && 
    isset($_POST["categoriesProd"]) && is_string($_POST["categoriesProd"]) && 
    isset($_POST["descriptionProd"]) && is_string($_POST["descriptionProd"]) && 
    isset($_POST["priceProd"]) && is_numeric($_POST["priceProd"]) && 
    isset($_POST["quantityProd"]) && is_numeric($_POST["quantityProd"]) && 
    isset($_POST["imageProd"]) && is_string($_POST["imageProd"]) && 
    isset($_POST["visibilityProd"]) && is_bool($_POST["visibilityProd"])) 
    {
        $dbh->insertNewProduct($_POST["nomeProd"], $_POST["priceProd"], $_POST["quantityProd"], $_POST["visibilityProd"], $_POST["imageProd"], $_POST["descriptionProd"], $_SESSION["userId"] = $userId);
    }

    require('./layouts/header.php');
    require('./newProduct.php');

    if (!empty($templateParams['products'])) {
        include('.\cliente\productgrid.php');
    }
    
    require('./layouts/footer.php');
?>