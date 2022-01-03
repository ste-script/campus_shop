<?php
require_once 'bootstrap.php';
if (isUserLoggedIn()) {
    header("Location: index.php");
    exit;
}
$templateParams["titolo"] = "Campus Shop - Registrazione";
if (isset($_POST["clientEmail"]) && isset($_POST["password"]) && isset($_POST["cf"])) {
    $registerResult = $dbh->registerClient($_POST["clientEmail"], $_POST["password"], $_POST["cf"]);
    if (!$registerResult) {
        //Login errato
        $templateParams["erroreLogin"] = "Errore nella registrazione";
    } else {
        registerLoggedClient($_POST["clientEmail"], $dbh->getClientId($_POST["clientEmail"]));
        $dbh->newOrder($_SESSION["userId"]);
        header("Location: index.php");
        exit;
    }
}


require('./layouts/header.php');
require("./layouts/register-form.php");
require('./layouts/footer.php');
