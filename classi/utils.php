<?php
function registerLoggedClient($userEmail,$userId){
    $_SESSION["clientEmail"] = $userEmail;
    $_SESSION["userId"] = $userId;
}

function isUserLoggedIn(){
    return !empty($_SESSION['clientEmail']);
}

function getHeaderElements(){
    if (isUserLoggedIn()) {

        return [['link' => '#', 'nome' => 'Cart'],
                ['link' => '#', 'nome' => 'Card'],
                ['link' => '#', 'nome' => 'Order'],
                ['link' => 'client.php', 'nome' => 'Account'],
                ['link' => 'logout.php', 'nome' => 'Logout']
            ];
    } else {
        return [['link' => '#', 'nome' => 'Cart'],
                ['link' => '#', 'nome' => 'Card'],
                ['link' => '#', 'nome' => 'Order'],
                ['link' => 'login.php', 'nome' => 'Login']
            ];
    }
}