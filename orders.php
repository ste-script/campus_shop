<?php
require_once("./bootstrap.php");

$templateParams["titolo"] = "Campus Shop - Ordini";
include("./layouts/header.php");

if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit;
}
?>
<div class="container-xl">
    <div class="row mx-0">
        <div class="col text-center">
            <div class="text-capitalize pt-5 pb-2 h1">
                Ordini
            </div>
        </div>
    </div>
</div>
<?php
foreach ($dbh->getOrdersIdByClientId($_SESSION["userId"]) as $order) {
    foreach ($dbh->getShippingsFromOrder($order) as $shipping) {
        $templateParams['gridTitle'] = "Spedizione n: " . $shipping;
        $templateParams['shippingStatus'] = "Stato spedizione: " . $dbh->getShippingStatus($shipping);
        $templateParams['products'] = $dbh->getProductsFromShipping($shipping);
        include('.\cliente\shippinggrid.php');
    }
}



include("./layouts/footer.php");
