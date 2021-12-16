<body>
    <!-- BAR-->
    <nav class="navbar sticky-top bg-dark navbar-dark">

    <!-- Toggler/collapsibe Button -->
        <div class="dropdownMenu">
            <button class="btn btn-link dropdown" data-toggle="dropdown">
                <img src=".\img\logo.png" alt="Menu" style="width:50px;">
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
                <span class="navbar-toggler-icon" alt="UserMenu" ></span>
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