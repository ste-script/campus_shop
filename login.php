<?php
require_once 'bootstrap.php';
$templateParams["titolo"] = "Campus Shop - Login";
if (isset($_POST["clientEmail"]) && isset($_POST["clientPassword"])) {
    $login_result = $dbh->checkClientLogin($_POST["clientEmail"], $_POST["clientPassword"]);
    if (!$login_result) {
        //Login errato
        $templateParams["erroreLogin"] = "Credenziali di accesso errate";
    } else {
        registerLoggedClient($_POST["clientEmail"], $dbh->getClientId($_POST["clientEmail"]));
    }
}
if (isUserLoggedIn()) {
    header("Location: index.php");
    exit;
}

require('./layouts/headerCostumer.php');
require("./layouts/login-form.php");
require('./layouts/footer.php');
