<?php
    require_once("./bootstrap.php");
    $vendorName = $dbh->getVendorName($_GET["vendorId"]);
    $templateParams["titolo"] = "Campus Shop - ". ucfirst($vendorName);
    $templateParams['gridTitle'] = "Prodotti";
    $templateParams['products'] = $dbh->getVisibleProductsFromVendorId($_GET["vendorId"]);

    require('./layouts/header.php');

?>

<h1 class="mx-5 mt-5"><?php echo $vendorName;?></h1>
<h3 class="mx-5 mb-5 text-secondary"><?php echo $dbh->getVendorContacts($_GET["vendorId"])?></h3>
<?php   
    if (!empty($templateParams['products'])) {
        include('.\cliente\productgrid.php');
    }
    
    require('./layouts/footer.php');

?>