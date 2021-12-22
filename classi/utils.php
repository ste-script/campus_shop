<?php
function registerLoggedClient($userEmail, $userId)
{
    $_SESSION["clientEmail"] = $userEmail;
    $_SESSION["userId"] = $userId;
}

function isUserLoggedIn()
{
    return !empty($_SESSION['clientEmail']);
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
