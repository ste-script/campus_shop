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

//definisce gli elementi della navbar al contesto
function getHeaderElements()
{
    if (isUserLoggedIn()) {

        return [
            ['link' => '#', 'nome' => 'Categorie', 'title' => 'Categorie'],
            ['link' => 'cart.php', 'nome' => "Carrello<span id='cartCount'><span>", 'title' => 'Carrello'],
            ['link' => 'card.php', 'nome' => "Carte", 'title' => "Carte"],
            ['link' => 'orders.php', 'nome' => 'Ordini', 'title' => 'Ordini'],
            ['link' => 'account.php', 'nome' => 'Profilo', 'title' => 'Profilo'],
            ['link' => 'notifiche.php', 'nome' => '<span id="notifyicon" class="fas fa-bell"></span>', 'title' => 'Notifiche'],
            ['link' => 'logout.php', 'nome' => 'Esci', 'title' => 'Esci']
        ];
    } else if (isVendorLoggedIn()) {

        return [
            ['link' => "vendorProducts.php?vendorId=" . $_SESSION["userId"], 'nome' => 'Prodotti', 'title' => 'Prodotti'],
            ['link' => 'vendorOrder.php', 'nome' => 'Ordini', 'title' => 'Ordini'],
            ['link' => 'account.php', 'nome' => 'Profilo', 'title' => 'Profilo'],
            ['link' => 'notifiche.php', 'nome' => '<span id="notifyicon" class="fas fa-bell"></span>', 'title' => 'Notifiche'],
            ['link' => 'logout.php', 'nome' => 'Esci', 'title' => 'Esci']
        ];
    } else {
        return [
            ['link' => '#', 'nome' => 'Categorie', 'title' => 'Categorie'],
            ['link' => 'login.php', 'nome' => 'Carrello', 'title' => 'Carrello'],
            ['link' => 'login.php', 'nome' => 'Carte', 'title' => 'Carte'],
            ['link' => 'login.php', 'nome' => 'Ordini', 'title' => 'Ordini'],
            ['link' => 'login.php', 'nome' => 'Accedi', 'title' => 'Accedi'],
            ['link' => 'register.php', 'nome' => 'Registrati', 'title' => 'Registrati']
        ];
    }
}
