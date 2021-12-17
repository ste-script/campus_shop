<?php
function registerLoggedClient($userEmail){
    $_SESSION["clientEmail"] = $userEmail;
}

function isUserLoggedIn(){
    return !empty($_SESSION['clientEmail']);
}
?>