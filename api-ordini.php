<?php
require_once 'bootstrap.php';
if (isVendorLoggedIn() && $_GET["stato"] == "ordinati") {
    $orders = $dbh->getProgressShippingFromVendorId($_SESSION["userId"]);
} else if (isVendorLoggedIn() && $_GET["stato"] == "spediti") {
    $orders = $dbh->getDeliveredShippingFromVendorId($_SESSION["userId"]);
}
header('Content-Type: application/json');
echo json_encode($orders);
