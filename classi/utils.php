<?php
function registerLoggedClient($userEmail, $userId)
{
    $_SESSION["clientEmail"] = $userEmail;
    $_SESSION["userId"] = $userId;
    $_SESSION["loginType"] = "client";
}

function registerLoggedVendor($userEmail, $userId)
{
    $_SESSION["clientEmail"] = $userEmail;
    $_SESSION["userId"] = $userId;
    $_SESSION["loginType"] = "vendor";
}

function isUserLoggedIn()
{
    return !empty($_SESSION['clientEmail']) && $_SESSION["loginType"] == "client";
}

function isVendorLoggedIn()
{
    return !empty($_SESSION['clientEmail']) && $_SESSION["loginType"] == "vendor";
}

function getHeaderElements()
{
    if (isUserLoggedIn()) {

        return [
            ['link' => '#', 'nome' => 'Categorie'],
            ['link' => 'cart.php', 'nome' => 'Carrello'],
            ['link' => 'card.php', 'nome' => 'Carte'],
            ['link' => 'orders.php', 'nome' => 'Ordini'],
            ['link' => 'account.php', 'nome' => 'Profilo'],
            ['link' => 'notifiche.php', 'nome' => '<i id="notifyicon" class="fas fa-bell"></i>'],
            ['link' => 'logout.php', 'nome' => 'Esci']
        ];
    } else if (isVendorLoggedIn()) {

        return [
            ['link' => "vendorProducts.php?vendorId=" . $_SESSION["userId"], 'nome' => 'Prodotti'],
            ['link' => 'vendorOrder.php', 'nome' => 'Ordini'],
            ['link' => 'account.php', 'nome' => 'Profilo'],
            ['link' => 'notifiche.php', 'nome' => '<i id="notifyicon" class="fas fa-bell"></i>'],
            ['link' => 'logout.php', 'nome' => 'Esci']
        ];
    } else {
        return [
            ['link' => '#', 'nome' => 'Categorie'],
            ['link' => 'login.php', 'nome' => 'Carrello'],
            ['link' => 'login.php', 'nome' => 'Carte'],
            ['link' => 'login.php', 'nome' => 'Ordini'],
            ['link' => 'login.php', 'nome' => 'Accedi']
        ];
    }
}
