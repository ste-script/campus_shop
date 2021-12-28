<?php
require_once("./bootstrap.php");

$templateParams["titolo"] = "Campus Shop - Carte";
include("./layouts/header.php");

if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit;
}
var_dump($_POST["card"], $_POST["date"], $_SESSION["userId"], $_POST["cvv"]);
if (isset($_POST["card"]) && is_numeric($_POST["card"]) && isset($_POST["cvv"]) && is_numeric($_POST["cvv"]) && isset($_POST["date"])) {
    $dbh->addNewCard($_POST["card"], $_POST["date"], $_SESSION["userId"], $_POST["cvv"]);
}

if (isset($_POST["removeProduct"]) && $_POST["removeProduct"] == 1) {
    $dbh->deleteCard($_POST["cardId"]);
}

$templateParams['gridTitle'] = "Carte";
$templateParams['products'] = $dbh->getCardsFromIdClient($_SESSION["userId"]);


include('./cliente/cardGrid.php');


include("./layouts/footer.php");
