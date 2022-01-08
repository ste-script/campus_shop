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
    <script src="./class/script.js"></script>
    <link rel="shortcut icon" href=<?php echo '"' . UPLOAD_DIR . 'favicon.ico"' ?> type="image/x-icon">
    <link rel="icon" href=<?php echo '"' . UPLOAD_DIR . 'favicon.ico"' ?> type="image/x-icon">

    <script>
        $(document).ready(function() {
            updateHeader();
            setInterval(updateHeader, 20000);
        });
    </script>

</head>



<body class="min-vh-100 d-flex flex-column bg-light">
    <!-- BAR-->
    <nav class="navbar navbar-expand-lg sticky-top bg-dark navbar-dark">
        <!-- Toggler/collapsibe Button -->
        <a class="navbar-brand btn btn-default" href="index.php">
            <img id="logoImg" src="./img/logo.png" alt="HomePage">
        </a>

        <button class="navbar-toggler fas fa-bars" type="button" id="menuicon" style="color:#fff; font-size:28px;" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"></button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <form class="d-flex ms-auto ps-2" action="search.php" method="GET" role='search'>
                <label for='productName'>
                    <span class='visually-hidden'>Cerca prodotto</span>
                </label>
                <div class="dropdown">
                    <input class="form-control me-2 w-auto dropdown-toggle" onkeyup="searchProducts()" autocomplete="off" data-bs-toggle="dropdown" aria-label="Cerca prodotti" type="search" placeholder="Cerca prodotti" id="productName" name="productName">
                    <ul class="dropdown-menu" aria-labelledby="productName" id="productList">

                    </ul>
                </div>
                <button class="btn " type="submit">
                    <span class="fa fa-search text-white"></span>
                </button>
            </form>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 ps-1">
                <?php foreach ($templateParams["headerMenu"] as $item) : ?>
                    <?php if ($item["nome"] == "Categorie") : ?>
                        <li class="nav-item dropdown dropstart">
                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown">
                                <?php echo $item["nome"] ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <?php
                                foreach ($dbh->getCategories() as $category) : ?>
                                    <li><a class="dropdown-item text-capitalize" href="categoryGrid.php?categoryId=<?php echo $category["id"]; ?>"> <?php echo $category["nome"]; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php else : ?>
                        <li class="nav-item ms-2">
                            <a class="nav-link" href="<?php echo $item["link"]; ?>" title="<?php echo $item["title"]; ?>"><?php echo $item["nome"]; ?></a>
                        </li>
                    <?php endif; ?>
                <?php endforeach ?>
            </ul>

        </div>
    </nav>
    <!-- /BAR-->