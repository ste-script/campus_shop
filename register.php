<?php
require_once 'bootstrap.php';
if (isUserLoggedIn()) {
    header("Location: index.php");
    exit;
}
$templateParams["titolo"] = "Campus Shop - Registrazione";
if (isset($_POST["clientEmail"]) && isset($_POST["clientPassword"]) && isset($_POST["cf"])) {
    $registerResult = $dbh->registerClient($_POST["clientEmail"], $_POST["clientPassword"], $_POST["cf"]);
    if (!$registerResult) {
        //Login errato
        $templateParams["erroreLogin"] = "Errore nella registrazione";
    } else {
        registerLoggedClient($_POST["clientEmail"], $dbh->getClientId($_POST["clientEmail"]));
    }
}


require('./layouts/headerCostumer.php');
require("./layouts/register-form.php");
require('./layouts/footer.php');
