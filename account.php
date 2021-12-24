<?php
require_once("./bootstrap.php");

$templateParams["titolo"] = "Campus Shop - Profilo";
include("./layouts/header.php");

if (!isUserLoggedIn() && !isVendorLoggedIn()) {
    header("Location: login.php");
    exit;
}


if (isset($_POST["newMail"]) && is_string($_POST["newMail"]) && isset($_POST["checkNewMail"]) && $_POST["newMail"] == $_POST["checkNewMail"]) {
    if (isUserLoggedIn()) {
        if ($dbh->changeMailClient($_POST["newMail"], $_SESSION["userId"])) {
            $_SESSION["clientEmail"] = $_POST["newMail"];
        }
    } else {
        if ($dbh->changeMailVendor($_POST["newMail"], $_SESSION["userId"])) {
            $_SESSION["clientEmail"] = $_POST["newMail"];
        }
    }
}

if (isset($_POST["oldPassword"]) && is_string($_POST["oldPassword"]) && isset($_POST["newPassword"]) && is_string($_POST["newPassword"]) && isset($_POST["checkNewPassword"]) && $_POST["newPassword"] == $_POST["checkNewPassword"]) {
    if (isUserLoggedIn() && $dbh->checkClientLogin($_SESSION["clientEmail"], $_POST["oldPassword"]) ) {
        if (!$dbh->changePasswordClient($_POST["newPassword"], $_SESSION["userId"])) {
            //return false
        }
    } elseif($dbh->checkVendorLogin($_SESSION["clientEmail"], $_POST["oldPassword"])) {
        if (!$dbh->changePasswordVendor($_POST["newPassword"], $_SESSION["userId"])) {
            //return false
        }
    }
}

$templateParams['gridTitle'] = "Account";
$templateParams['products'] = $dbh->getCardsFromIdClient($_SESSION["userId"]);


include('./cliente/accountGrid.php');


include("./layouts/footer.php");
