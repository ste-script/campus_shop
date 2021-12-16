<body>
    <!-- BAR-->
    <nav class="navbar sticky-top bg-dark navbar-dark">
    <div class="container-fluid">

    <!-- Toggler/collapsibe Button -->
        <div class="dropdown nav-item">
        <a class="nav-link dropdown-toggle" href="#" id="navCategoriesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <img src=".\img\logo.png" alt="Menu" style="width:50px;">
          </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Category 1</a>
                <a class="dropdown-item" href="#">Category 2</a>
                <a class="dropdown-item" href="#">Category 3</a>
            </div>
        </div>


        <form class="d-flex" action="/action_page.php">
            <input class="form-control me-2 w-auto" type="search" placeholder="Search">
            <button class="btn " type="submit">
                <span class="fa fa-search"  style="color:white"></span>
            </button>
        </form>


        <div class="dropdown nav-item">
        <a class="nav-link" href="#" id="navMenuDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="navbar-toggler-icon" alt="UserMenu" ></span>
        </a>
            <div class="dropdown-menu end-0">
                <a class="dropdown-item" href="#">Cart</a>
                <a class="dropdown-item" href="#">Orders</a>
                <a class="dropdown-item" href="#">Card</a>
                <a class="dropdown-item" href="#">Account</a>
            </div>
        </div>
    </div>
    </nav>

    <!-- /BAR-->