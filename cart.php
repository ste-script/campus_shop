<?php
require_once("./bootstrap.php");

$templateParams["titolo"] = "Campus Shop - Carrello";
include("./layouts/header.php");

if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit;
}
if (isset($_POST["removeProduct"]) && $_POST["removeProduct"] == 1) {
    $dbh->deleteCollo($dbh->getLastOrderIdByClientId($_SESSION['userId']), $_POST["productId"]);
} elseif (isset($_POST["removeProduct"]) && $_POST["removeProduct"] == 0) {
    $dbh->updateColloQuantity($_POST["quantity"], $dbh->getLastOrderIdByClientId($_SESSION['userId']), $_POST["productId"]);
}
if (isset($_POST["cards"]) && is_numeric($_POST["cards"]) && isset($_POST["cvv"])) {
    if ($dbh->cechCardCvv($_POST["cards"], $_POST["cvv"])) {
        $dbh->startOrder($dbh->getLastOrderIdByClientId($_SESSION['userId']), $_POST["cards"], $_SESSION['userId']);
    }
}

$templateParams['gridTitle'] = "Carrello";
$templateParams['products'] = $dbh->getCartProductsByClientId($_SESSION['userId']);
include('.\cliente\cartgrid.php');


include("./layouts/footer.php");
