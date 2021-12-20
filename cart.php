<?php
require_once("./bootstrap.php");

$templateParams["titolo"] = "Campus Shop - Carrello";
include("./layouts/headerCostumer.php");

if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit;
}
if (isset($_POST["removeProduct"]) && $_POST["removeProduct"] == 1) {
    
} elseif (isset($_POST["removeProduct"]) && $_POST["removeProduct"] == 0) {

}
$templateParams['gridTitle'] = "Carrello";
$templateParams['products'] = $dbh->getCartProductsByClientId($_SESSION['userId']);
if (!empty($templateParams['products'])) {
    include('.\cliente\cartgrid.php');
}

include("./layouts/footer.php");
