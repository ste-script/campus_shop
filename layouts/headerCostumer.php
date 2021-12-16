<body>
    <!-- BAR-->
    <nav class="navbar navbar-expand-lg sticky-top bg-dark navbar-dark">
        <div class="container-fluid">

            <!-- Toggler/collapsibe Button -->
            <div class="dropdown navbar-brand">
                <a class="nav-link dropdown-toggle" href="#" id="navCategoriesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="" src=".\img\logo.png" alt="Menu" style="width:50px;"> <!-- CSS -->
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
                <form class="d-flex ms-auto" action="/action_page.php">
                    <input class="form-control me-2 w-auto" type="search" placeholder="Search">
                    <button class="btn " type="submit">
                        <span class="fa fa-search text-white"></span> 
                    </button>
                </form>

                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 ">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Cart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Card</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Settings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Other</a>
                    </li>
                </ul>

            </div>
        </div>
        </div>
    </nav>

    <!-- /BAR-->