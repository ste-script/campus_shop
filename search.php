<?php
require_once("./bootstrap.php");
if (!isset($_GET["productName"]) || !is_string($_GET["productName"])) {
    header("Location: index.php");
    exit;
}

$templateParams["titolo"] = "Ricerca di " . $_GET["productName"];
include('./layouts/header.php');

$templateParams["products"] = $dbh->getProductsByName($_GET["productName"]);
$templateParams['products'] ? $templateParams['gridTitle'] = "Ricerca di " . $_GET["productName"] : $templateParams['gridTitle'] = "Nessun Prodotto";

include('./user/productGrid.php');
include('./layouts/footer.php');
