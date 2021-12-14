<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script><title>Campus Shop</title>
</head>

<body>
    <!-- BAR-->
    <nav class="navbar navbar-expand-sm sticky-top bg-dark navbar-dark">

    <!-- Toggler/collapsibe Button -->
        <div class="dropdownMenu">
            <button class="btn btn-link dropdown" data-toggle="dropdown">
                <img src="..\img\logo.png" alt="Logo" style="width:50px;">
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Category 1</a>
                <a class="dropdown-item" href="#">Category 2</a>
                <a class="dropdown-item" href="#">Category 3</a>
            </div>
        </div>

        <form class="form-inline" action="/action_page.php">
            <input class="form-control w-auto" type="text" placeholder="Search">
            <button class="btn" type="submit">
                <span class="fa fa-search"  style="color:white"></span>
            </button>
        </form>

        <div class="dropdownMenu">
            <button class="btn btn-link dropdown" data-toggle="dropdown">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="#">Cart</a>
                <a class="dropdown-item" href="#">Orders</a>
                <a class="dropdown-item" href="#">Card</a>
                <a class="dropdown-item" href="#">Account</a>
            </div>
        </div>
    </nav>

    <!-- /BAR-->