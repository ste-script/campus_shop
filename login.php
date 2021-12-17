<?php
require_once 'bootstrap.php';
$templateParams["titolo"] = "Campus Shop - Login";
if(isset($_POST["clientEmail"]) && isset($_POST["clientPassword"])){
    $login_result = $dbh->checkClientLogin($_POST["clientEmail"], $_POST["clientPassword"]);
    if(!$login_result){
        //Login fallito
        $templateParams["errorelogin"] = "Errore! Controllare username o password!";
    }
    else{
        registerLoggedClient($_POST["clientEmail"]);
    }
}
echo password_hash("1234",PASSWORD_DEFAULT);

if(isUserLoggedIn()){
    $templateParams["titolo"] = "Campus Shop - Home";
    $templateParams["headerMenu"] = [
        ['link' => '#', 'nome' => 'Cart'],
        ['link' => '#', 'nome' => 'Card'],
        ['link' => '#', 'nome' => 'Order'],
        ['link' => 'logout.php', 'nome' => 'Logout']
    ];
}
else{
    $templateParams["titolo"] = "Campus Shop - Login";
    $templateParams["headerMenu"] = [
        ['link' => '#', 'nome' => 'Cart'],
        ['link' => '#', 'nome' => 'Card'],
        ['link' => '#', 'nome' => 'Order'],
        ['link' => 'login.php', 'nome' => 'Login']
    ];
}

require('./layouts/headerCostumer.php');
require("./layouts/login-form.php");
require('./layouts/footer.php');
