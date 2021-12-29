<?php

require_once("./bootstrap.php");

if (!isVendorLoggedIn()) {
    header("Location: index.php");
    exit;
}
    $dbh->newCategory($_POST["categoryName"]);
    header("Location: " . $_SERVER["HTTP_REFERER"]);
    exit;
?>