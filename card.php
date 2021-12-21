<?php
require_once("./bootstrap.php");

$templateParams["titolo"] = "Campus Shop - Carte";
include("./layouts/headerCostumer.php");

if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit;
}

if (isset($_POST["card"]) && is_numeric($_POST["card"]) && isset($_POST["cvv"]) && is_numeric($_POST["cvv"]) && isset($_POST["date"]))  {
    $dbh->addNewCard($_POST["card"], $_POST["date"], $_SESSION["userId"], $_POST["cvv"]);
}

$templateParams['gridTitle'] = "Carte";
$templateParams['products'] = $dbh->getCardsFromIdClient($_SESSION["userId"]);

if (!empty($templateParams['products'])) {
    include('.\cardGrid.php');
}

include("./layouts/footer.php");
