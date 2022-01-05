<?php
require_once("./bootstrap.php");
if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit;
}
$templateParams["titolo"] = "Campus Shop - Carte";
include("./layouts/header.php");
isset($_POST["card"]) ? $card=str_replace("-","", $_POST["card"]) : $card = NULL;
if (is_numeric($card) && isset($_POST["cvv"]) && is_numeric($_POST["cvv"]) && isset($_POST["month"]) && isset($_POST["year"])) {
    
    $date=$_POST["year"].($_POST["month"] < 10 ? "0".$_POST["month"] : $_POST["month"])."01";
    $dbh->addNewCard(str_replace("-","", $_POST["card"]), $date, $_SESSION["userId"], $_POST["cvv"]);
}

if (isset($_POST["removeProduct"]) && $_POST["removeProduct"] == 1) {
    $dbh->deleteCard($_POST["cardId"]);
}

$templateParams['gridTitle'] = "Carte";
$templateParams['products'] = $dbh->getCardsFromIdClient($_SESSION["userId"]);
include('./cliente/cardGrid.php');


include("./layouts/footer.php");
