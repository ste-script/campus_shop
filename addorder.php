<?php
require('bootstrap.php');
if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit;
}
if (isset($_POST["quantity"]) && is_numeric($_POST["quantity"])) {
    $dbh->orderProduct($_POST["productId"], $_POST["quantity"], $_SESSION["userId"]);
    
header("Location: product.php?productId=" . $_POST["productId"]. "&ordered=" . $_POST["quantity"]);
}
