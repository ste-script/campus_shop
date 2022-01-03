<?php
require_once("./bootstrap.php");
if (!is_string($_GET["productName"])) {
    header("Location: index.php");
    exit;
}
$prod = $dbh->getProductsNameByName($_GET["productName"]);
header('Content-Type: application/json');
echo json_encode($prod);
