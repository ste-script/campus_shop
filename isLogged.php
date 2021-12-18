<?php
if (isUserLoggedIn()) {

    $templateParams["headerMenu"] = [
        ['link' => '#', 'nome' => 'Cart'],
        ['link' => '#', 'nome' => 'Card'],
        ['link' => '#', 'nome' => 'Order'],
        ['link' => 'client.php', 'nome' => 'Account'],
        ['link' => 'logout.php', 'nome' => 'Logout']
    ];
} else {
    $templateParams["headerMenu"] = [
        ['link' => '#', 'nome' => 'Cart'],
        ['link' => '#', 'nome' => 'Card'],
        ['link' => '#', 'nome' => 'Order'],
        ['link' => 'login.php', 'nome' => 'Login']
    ];
}
?>