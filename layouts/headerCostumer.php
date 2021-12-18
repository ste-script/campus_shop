<!DOCTYPE html>
<html lang="it">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo  $templateParams["titolo"]; ?></title>

    <!-- Bootstrap and Fontawesome CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <!-- BAR-->
    <nav class="navbar navbar-expand-lg sticky-top bg-dark navbar-dark">
        <div class="container-fluid">

            <!-- Toggler/collapsibe Button -->
            <div class="dropdown navbar-brand">
                <a class="nav-link dropdown-toggle" href="#" id="navCategoriesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img id="logoImg" src="./img/logo.png" alt="Menu">
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">Category 1</a>
                    <a class="dropdown-item" href="#">Category 2</a>
                    <a class="dropdown-item" href="#">Category 3</a>
                </div>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <form class="d-flex ms-auto" action="search.php" method="GET">
                    <input class="form-control me-2 w-auto" type="search" placeholder="Search" id="productName" name="productName">
                    <button class="btn " type="submit">
                        <span class="fa fa-search text-white"></span>
                    </button>
                </form>

                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 ">
                    <?php foreach ($templateParams["headerMenu"] as $item) :
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $item["link"]; ?>"><?php echo $item["nome"]; ?></a>
                        </li>
                    <?php endforeach ?>
                </ul>

            </div>
        </div>
    </nav>

    <!-- /BAR-->