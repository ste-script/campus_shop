<?php
    require_once("./bootstrap.php");
    $templateParams["titolo"] = "Campus Shop - ". ucfirst($_GET["vendorName"]);
    $templateParams['gridTitle'] = "Prodotti";
    $templateParams['products'] = $dbh->getProductsFromVendorName($_GET["vendorName"]);

    require('./layouts/headerCostumer.php');

?>

<h1 class="mx-5 mt-5"><?php echo $_GET["vendorName"];?></h1>
<h3 class="mx-5 mb-5 text-secondary"><?php echo $dbh->getVendorContacts($_GET["vendorName"])?></h3>
<?php   
    if (!empty($templateParams['products'])) {
        include('.\cliente\productgrid.php');
    }
    
    require('./layouts/footer.php');

?>