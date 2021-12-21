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
            ['link' => '#', 'nome' => 'Categories'],
            ['link' => 'cart.php', 'nome' => 'Carrello'],
            ['link' => 'card.php', 'nome' => 'Card'],
            ['link' => '#', 'nome' => 'Orders'],
            ['link' => 'client.php', 'nome' => 'Account'],
            ['link' => 'logout.php', 'nome' => 'Logout']
        ];
    } else {
        return [
            ['link' => '#', 'nome' => 'Categories'],
            ['link' => 'login.php', 'nome' => 'Carrello'],
            ['link' => 'login.php', 'nome' => 'Card'],
            ['link' => 'login.php', 'nome' => 'Orders'],
            ['link' => 'login.php', 'nome' => 'Login']
        ];
    }
}
