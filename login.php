<?php
require_once 'bootstrap.php';
$templateParams["titolo"] = "Campus Shop - Login";
$templateParams["headerMenu"] = [
    ['link' => '#', 'nome' => 'Cart'],
    ['link' => '#', 'nome' => 'Card'],
    ['link' => '#', 'nome' => 'Order'],
    ['link' => 'login.php', 'nome' => 'Login']
];
require('./layouts/headerCostumer.php');
require("./layouts/login-form.php");
require('./layouts/footer.php');
?>