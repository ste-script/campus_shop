<?php
require_once("./bootstrap.php");

$templateParams["titolo"] = "Campus Shop - Profilo";
include("./layouts/headerCostumer.php");

if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit;
}


if (isset($_POST["newMail"]) && is_string($_POST["newMail"]) && isset($_POST["checkNewMail"]) && $_POST["newMail"]==$_POST["checkNewMail"] ) {
    $dbh->changeMail($_POST["newMail"], $_SESSION["userId"]);
}

if (isset($_POST["oldPassword"]) && is_string($_POST["oldPassword"]) && isset($_POST["newPassword"]) && is_string($_POST["newPassword"]) && isset($_POST["checkNewPassword"]) && $_POST["newPassword"]==$_POST["checkNewPassword"]) {
    if($dbh->checkClientLogin($_SESSION["clientEmail"], $_POST["oldPassword"])){
        if(!$dbh->changePassword($_POST["newPassword"], $_SESSION["userId"])){
            //return false
        }
    }
}

$templateParams['gridTitle'] = "Account";
$templateParams['products'] = $dbh->getCardsFromIdClient($_SESSION["userId"]);


include('./cliente/accountGrid.php');


include("./layouts/footer.php");