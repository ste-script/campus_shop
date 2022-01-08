<?php
    require_once("./bootstrap.php");
    $vendorName = $dbh->getVendorName($_GET["vendorId"]);
    $templateParams["titolo"] = "Campus Shop - ". ucfirst($vendorName);
    $templateParams['gridTitle'] = "Prodotti";
    $templateParams['products'] = $dbh->getVisibleProductsFromVendorId($_GET["vendorId"]);

    require('./layouts/header.php');

?>

<div class="mx-5 mt-5 h1"><?php echo $vendorName;?></div>
<div class="mx-5 mb-5 text-secondary h3"><?php echo $dbh->getVendorContacts($_GET["vendorId"])?></div>
<?php   
    if (!empty($templateParams['products'])) {
        include('./user/productGrid.php');
    }
    
    require('./layouts/footer.php');

?>