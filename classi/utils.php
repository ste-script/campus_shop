<?php
function registerLoggedClient($userEmail,$userId){
    $_SESSION["clientEmail"] = $userEmail;
    $_SESSION["userId"] = $userId;
}

function isUserLoggedIn(){
    return !empty($_SESSION['clientEmail']);
}
