<?php
require_once("./bootstrap.php");
if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit;
}
$templateParams["titolo"] = "Campus Shop - Ordini";
$orders = $dbh->getOrdersIdByClientId($_SESSION["userId"]);
include("./layouts/header.php");
?>
<div class="container-xl">
    <div class="row mx-0">
        <div class="col text-center">
            <div class="text-capitalize pt-5 pb-2 h1">
                Ordini
            </div>
        </div>
    </div>
    <?php if (count($orders) == 1) : ?>
        <div class="row mx-0">
            <div class="col text-center">
                <div class="text-capitalize pt-5 pb-2 h3">
                    Nessun Ordine
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php

foreach ($orders as $order) {
    foreach ($dbh->getShippingsFromOrder($order) as $shipping) {
        $templateParams['gridTitle'] = "Spedizione n: " . $shipping;
        $templateParams['shippingStatus'] = "Stato spedizione: " . $dbh->getShippingStatus($shipping);
        $templateParams['products'] = $dbh->getProductsFromShipping($shipping);
        $templateParams['cost'] = $dbh->getShippingCost($shipping);
        include('.\cliente\shippinggrid.php');
    }
}

include("./layouts/footer.php");
