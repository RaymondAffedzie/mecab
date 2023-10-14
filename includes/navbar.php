<body>
    <header class="p-3">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center border-bottom pb-3 justify-content-center justify-content-lg-start">
                <a href="index.php" class="d-flex align-items-center me-3 mb-2 mb-lg-0 h3 link-body-emphasis text-decoration-none">
                    MeCAB
                </a>

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="index.php" class="nav-link px-2 link-body-emphasis">Home</a></li>
                    <li><a href="about-us.php" class="nav-link px-2 link-body-emphasis">About us</a></li>
                    <li><a href="mechanics.php" class="nav-link px-2 link-body-emphasis">Mechanic</a></li>
                    <li class="dropdown">
                        <a href="#" class="nav-link px-2 link-body-emphasis dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Spare parts</a>
                        <ul class="dropdown-menu text-small">
                            <?php
                            $query = "SELECT category_id, category_name FROM categories ORDER BY category_name ASC;";
                            $category = $controller->getRecords($query);
                            foreach ($category as $data) {
                            ?>
                                <li><a class="dropdown-item" href="category-spare-parts.php?category=<?= $data['category_id']; ?>"><?= $data['category_name']; ?></a></li>
                            <?php } ?>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="nav-link px-2 link-body-emphasis dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Services</a>
                        <ul class="dropdown-menu text-small">
                            <li><a class="dropdown-item" href="#">Car Rental</a></li>
                            <li><a class="dropdown-item" href="#">Transport</a></li>
                            <li><a class="dropdown-item" href="#">Jobs</a></li>
                        </ul>
                    </li>
                </ul>

                <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                    <div class="input-group">
                        <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
                        <button class="btn btn-outline-secondary" type="button"><i class="ti-search"></i></button>
                    </div>
                </form>

                <div class="mx-5">
                    <!-- <i class="p-1 text-info ti-bell"><small>1</small></i> -->
                    <a href="#" class="px-2">
                        <i class="text-info fs-5 ti-bell position-relative">
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill text-info" id="notificationCount" data-cart-render="notification_count"></span>
                        </i>
                    </a>
                    <a href="cart.php" class="px-2">
                        <i class="text-warning fs-5 ti-shopping-cart position-relative">
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill text-warning" id="cartItemCount" data-cart-render="item_count"></span>
                        </i>
                    </a>
                    <i class="px-2 text-primary fs-5 ti-search"></i>
                </div>

                <div class="dropdown text-end">
                    <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="p-1 ti-face-smile text-primary"></i> Hello! <?= $_SESSION['fullName']; ?>
                    </a>
                    <ul class="dropdown-menu text-small">
                        <?php
                        if (isset($_SESSION['loggedIn'])) {
                        ?>
                            <li><a class="dropdown-item" href="../profile.php"><i class="p-1 ti-user text-success"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="../my-orders.php"><i class="p-1 mdi mdi-truck-delivery text-info"></i> My rders</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#" id="logoutForm"><i class="ti-power-off text-danger"></i> Sign out</a></li>
                        <?php
                        } else {
                        ?>
                            <li><a class="dropdown-item text-success text-decoration-none" href="../login.php"><i class="p-1 ti-power-off"></i> Sign in</a></li>
                            <li><a class="dropdown-item text-primary text-decoration-none" href="../register-user.php"><i class="p-1 ti-user"></i> Create account</a></li>
                            <li><a class="dropdown-item text-primary text-decoration-none" href="../register-store.php"><i class="p-1 ti-link"></i> Purchase store</a></li>
                        <?php
                        }
                        ?>

                    </ul>
                </div>
            </div>
        </div>
    </header>
    <div class="pageWrapper">
        <!--Body Content-->
        <div id="page-content">