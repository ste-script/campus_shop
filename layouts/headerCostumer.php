<?php $templateParams["headerMenu"] = getHeaderElements(); ?>
<!DOCTYPE html>
<html lang="it">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo  $templateParams["titolo"]; ?></title>

    <!-- Bootstrap and Fontawesome CSS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/style.css">

</head>

<body class="min-vh-100 d-flex flex-column">
    <!-- BAR-->
    <nav class="navbar navbar-expand-lg sticky-top bg-dark navbar-dark">
        <!-- Toggler/collapsibe Button -->
        <a class="navbar-brand btn btn-default" href="index.php">
            <img id="logoImg" src="./img/logo.png" alt="HomePage">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <form class="d-flex ms-auto" action="search.php" method="GET" role='search'>
                <label for='productName'>
                    <span class='visually-hidden'>Cerca prodotto</span>
                </label>
                <input class="form-control me-2 w-auto" aria-label="Cerca prodotti" type="search" placeholder="Cerca prodotti" id="productName" name="productName">
                <button class="btn " type="submit">
                    <span class="fa fa-search text-white"></span>
                </button>
            </form>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 ">
                <?php foreach ($templateParams["headerMenu"] as $item) : ?>
                    <?php if ($item["nome"] == "Categorie") : ?>
                        <li class="nav-item dropdown dropstart">
                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown">
                                <?php echo $item["nome"] ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <?php
                                foreach ($dbh->getCategories() as $category) : ?>
                                    <li><a class="dropdown-item text-capitalize" href="categoryGrid.php?categoryName=<?php echo $category["nome"]; ?>"> <?php echo $category["nome"]; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php else : ?>
                        <li class="nav-item ms-2">
                            <a class="nav-link" href="<?php echo $item["link"]; ?>"><?php echo $item["nome"]; ?></a>
                        </li>
                    <?php endif; ?>
                <?php endforeach ?>
            </ul>

        </div>
    </nav>

    <!-- /BAR-->