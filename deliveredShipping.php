<?php
require('bootstrap.php');
if (!isVendorLoggedIn()) {
    header("Location: login.php");
    exit;
}
if (isset($_POST["shippingId"])) {
    $dbh->deliverShipping($_POST["shippingId"]);

    header("Location: vendorOrder.php");
}
