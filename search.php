<?php
require_once("./bootstrap.php");
if (!isset($_GET["productName"]) || !is_string($_GET["productName"])) {
    header("Location: index.php");
    exit;
}
$prod = $dbh->getProductsByName($_GET["productName"]);
$templateParams["titolo"] = "Ricerca di " . $_GET["productName"];
include('./layouts/header.php');

$templateParams["gridTitle"] = "Ricerca di " . $_GET["productName"];
$templateParams["products"] = $prod;
if (!empty($prod)) {
    include('.\cliente\productgrid.php');
}

include('./layouts/footer.php');
