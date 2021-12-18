<?php
require_once("./bootstrap.php");
if (!isset($_GET["productName"]) || !is_string($_GET["productName"])) {
    header("Location: index.php");
    exit;
}
$prod = $dbh->getProductsByName($_GET["productName"]);
$templateParams["titolo"] = "Campus Shop - Home";
if (isUserLoggedIn()) {

    $templateParams["headerMenu"] = [
        ['link' => '#', 'nome' => 'Cart'],
        ['link' => '#', 'nome' => 'Card'],
        ['link' => '#', 'nome' => 'Order'],
        ['link' => 'client.php', 'nome' => 'Account'],
        ['link' => 'logout.php', 'nome' => 'Logout']
    ];
} else {
    $templateParams["headerMenu"] = [
        ['link' => '#', 'nome' => 'Cart'],
        ['link' => '#', 'nome' => 'Card'],
        ['link' => '#', 'nome' => 'Order'],
        ['link' => 'login.php', 'nome' => 'Login']
    ];
}
include('./layouts/headerCostumer.php');

$templateParams["gridTitle"] = "Ricerca di " . $_GET["productName"];
$templateParams["products"] = $prod;
if (!empty($prod)) {
    include('.\cliente\productgrid.php');
}

include('./layouts/footer.php');
