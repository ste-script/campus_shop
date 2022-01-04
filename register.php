<?php
require_once 'bootstrap.php';
if (isUserLoggedIn()) {
    header("Location: index.php");
    exit;
}
$templateParams["titolo"] = "Campus Shop - Registrazione";
if (isset($_POST["registerEmail"]) && isset($_POST["password"]) && isset($_POST["cf"]) && isset($_POST["registerType"])) {        
    if ($_POST["registerType"] == "venditore" && isset($_POST["name"])) {
        if ($dbh->registervendor($_POST["name"], $_POST["registerEmail"], $_POST["password"], $_POST["cf"])) {
            registerLoggedVendor($_POST["registerEmail"], $dbh->getVendorId($_POST["registerEmail"]));

            header("Location: index.php");
            exit;
        }
    } elseif ($_POST["registerType"] == "cliente") {
        if ($dbh->registerClient($_POST["registerEmail"], $_POST["password"], $_POST["cf"])) {
            registerLoggedClient($_POST["registerEmail"], $dbh->getClientId($_POST["registerEmail"]));
            $dbh->newOrder($_SESSION["userId"]);
            header("Location: index.php");
            exit;
        }
    }
    //Login errato
    $templateParams["erroreLogin"] = "Errore nella registrazione";
}


require('./layouts/header.php');
require("./layouts/register-form.php");
require('./layouts/footer.php');
