<?php
require_once("./bootstrap.php");

$templateParams["titolo"] = "Campus Shop - Ordini";
include("./layouts/headerCostumer.php");
$preparazione = $dbh->getProgressShippingFromVendorId($_SESSION["userId"]);
$spediti = $dbh->getDeliveredShippingFromVendorId($_SESSION["userId"]);
if (!isVendorLoggedIn()) {
    header("Location: login.php");
    exit;
}
if (!empty($preparazione)) :
?>
    <div class="container-xl">
        <div class="row mx-0">
            <div class="col text-center">
                <h2 class="text-capitalize pt-5 pb-2">
                    Ordini in preparazione
                </h2>
            </div>
        </div>
    </div>
<?php
endif;
foreach ($preparazione as $shipping) {
    $templateParams['gridTitle'] = "Spedizione n: " . $shipping["id"];
    $templateParams['shippingStatus'] = "Stato spedizione: " . $dbh->getShippingStatus($shipping["id"]);
    $templateParams["shippingIncome"] =  "Incasso: " . $shipping["incasso"];
    $templateParams["shippingDate"] =  "Data ordine: " . $shipping["data"];
    $templateParams['products'] = $dbh->getProductsFromShipping($shipping["id"]);

    include('.\venditore\shippinggrid.php');
}
if (!empty($spediti)) : ?>
    <div class="container-xl">
        <div class="row mx-0">
            <div class="col text-center">
                <h2 class="text-capitalize pt-5 pb-2">
                    Ordini spediti
                </h2>
            </div>
        </div>
    </div>
<?php
endif;
foreach ($spediti as $shipping) {
    $templateParams['gridTitle'] = "Spedizione n: " . $shipping["id"];
    $templateParams['shippingStatus'] = "Stato spedizione: " . $dbh->getShippingStatus($shipping["id"]);
    $templateParams['products'] = $dbh->getProductsFromShipping($shipping["id"]);
    include('.\venditore\shippinggrid.php');
}



include("./layouts/footer.php");
