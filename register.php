<?php
require_once 'bootstrap.php';
if (isUserLoggedIn()) {
    header("Location: index.php");
    exit;
}
$templateParams["titolo"] = "Campus Shop - Registrazione";
if (isset($_POST["clientEmail"]) && isset($_POST["clientPassword"])) {
    $login_result = $dbh->checkClientLogin($_POST["clientEmail"], $_POST["clientPassword"]);
    if (!$login_result) {
        //Login errato
        $templateParams["erroreLogin"] = "Credenziali di accesso errate";
    } else {
        registerLoggedClient($_POST["clientEmail"], $dbh->getClientId($_POST["clientEmail"]));
    }
}


require('./layouts/headerCostumer.php');
require("./layouts/register-form.php");
require('./layouts/footer.php');
