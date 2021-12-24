<?php
require_once 'bootstrap.php';
$templateParams["titolo"] = "Campus Shop - Login";

if (isset($_POST["clientEmail"]) && isset($_POST["clientPassword"]) && isset($_POST["loginType"]) && $_POST["loginType"] == "cliente") {
    $login_result = $dbh->checkClientLogin($_POST["clientEmail"], $_POST["clientPassword"]);
    if (!$login_result) {
        //Login errato
        $templateParams["erroreLogin"] = "Credenziali di accesso errate";
    } else {
        registerLoggedClient($_POST["clientEmail"], $dbh->getClientId($_POST["clientEmail"]));
    }
}

if (isset($_POST["clientEmail"]) && isset($_POST["clientPassword"]) && isset($_POST["loginType"]) && $_POST["loginType"] == "venditore") {
    $login_result = $dbh->checkVendorLogin($_POST["clientEmail"], $_POST["clientPassword"]);
    if (!$login_result) {
        //Login errato
        $templateParams["erroreLogin"] = "Credenziali di accesso errate";
    } else {
        registerLoggedVendor($_POST["clientEmail"], $dbh->getVendorId($_POST["clientEmail"]));
    }
}

if (isUserLoggedIn()) {
    header("Location: index.php");
    exit;
}

if (isVendorLoggedIn()) {
    header("Location: vendor.php");
    exit;
}

require('./layouts/headerCostumer.php');
require("./layouts/header");
require('./layouts/footer.php');
