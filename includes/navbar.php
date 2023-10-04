<body class="template-index home13-auto-parts">
    <div class="pageWrapper">
        <!--Search Form Drawer-->
        <div class="search">
            <div class="search__form">
                <form class="search-bar__form" action="#">
                    <button class="go-btn search__button" type="submit"><i class="icon anm anm-search-l"></i></button>
                    <input class="search__input" type="search" name="q" value="" placeholder="Search all stores store..." aria-label="Search" autocomplete="off">
                </form>
                <button type="button" class="search-trigger close-btn"><i class="anm anm-times-l"></i></button>
            </div>
        </div>
        <!--End Search Form Drawer-->

        <!--Top Header-->
        <div class="top-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-10 col-sm-8 col-md-5 col-lg-4">
                        <!-- <p class="phone-no"><i class="anm anm-phone-s"></i></p> -->
                    </div>
                    <div class="col-sm-4 col-md-4 col-lg-4 d-none d-lg-none d-md-block d-lg-block">
                        <div class="text-center">
                            <p class="top-header_middle-text"></p>
                        </div>
                    </div>
                    <div class="col-2 col-sm-4 col-md-3 col-lg-4 text-right">
                        <span class="user-menu d-block d-lg-none"><i class="anm anm-user-al" aria-hidden="true"></i></span>
                        <?php
                        if (isset($_SESSION['loggedIn'])) {
                        ?>
                            <ul class="customer-links list-inline">
                                <li>
                                    <a href="" id="logoutForm"><i class="ti-power-off text-primary"></i> Logout</a>
                                </li>
                            </ul>
                        <?php
                        } else {
                        ?>
                            <ul class="customer-links list-inline">
                                <li><a href="./login.php">Login</a></li>
                                <li><a href="./register-user.php">Create Account</a></li>
                                <li><a href="./register-store.php">Purchase Store</a></li>
                            </ul>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!--End Top Header-->

        <!--Header-->
        <div class="header-wrap animated d-flex">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <!--Desktop Logo-->
                    <div class="logo col-md-2 col-lg-2 d-none d-lg-block">
                        <a href="index.php" class="h1">
                            MeCAB
                        </a>
                    </div>
                    <!--End Desktop Logo-->
                    <div class="col-2 col-sm-3 col-md-3 col-lg-8">
                        <div class="d-block d-lg-none">
                            <button type="button" class="btn--link site-header__menu js-mobile-nav-toggle mobile-nav--open">
                                <i class="icon anm anm-times-l"></i>
                                <i class="anm anm-bars-r"></i>
                            </button>
                        </div>
                        <!--Desktop Menu-->
                        <nav class="grid__item" id="AccessibleNav" role="navigation">
                            <ul id="siteNav" class="site-nav medium center hidearrow">
                                <li class="lvl1"><a href="index.php">Home<i class="anm anm-angle-down-l"></i></a></li>
                                <li class="lvl1"><a href="about-us.php">About Us<i class="anm anm-angle-down-l"></i></a></li>
                                <li class="lvl1"><a href="mechanics.php">Mechanic<i class="anm anm-angle-down-l"></i></a></li>
                                <li class="lvl1 parent dropdown"><a href="#">Spare Parts <i class="anm anm-angle-down-l"></i></a>
                                    <ul class="dropdown scrollable-container">
                                        <?php
                                        $query = "SELECT * FROM categories ORDER BY category_name ASC;";
                                        $data = $controller->getRecords($query);
                                        foreach ($data as $category) {
                                            $categoryId = $category['category_id'];
                                            $categoryName = $category['category_name'];
                                        ?>
                                            <li>
                                                <a href="category-spare-parts.php?category=<?= $categoryId; ?>" class="site-nav"><?= $categoryName ?></a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                                <li class="lvl1 parent dropdown"><a href="#">Services <i class="anm anm-angle-down-l"></i></a>
                                    <ul class="dropdown scrollable-container">
                                        <li>
                                            <a href="#" class="site-nav">Car Rentals</a>
                                            <a href="#" class="site-nav">Transport Service</a>
                                        </li>
                                    </ul>
                                </li>

                            </ul>
                        </nav>
                        <!--End Desktop Menu-->
                    </div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-2 d-block d-lg-none mobile-logo">
                        <div class="logo">
                            <a href="index.php">
                                MeCAB
                            </a>
                        </div>
                    </div>
                    <div class="col-4 col-sm-3 col-md-3 col-lg-2">
                        <div class="site-cart">
                            <a href="#" class="site-header__cart" title="Cart">
                                <i class="icon anm anm-bag-l"></i>
                               
                                <span id="cartItemCount" class="site-header__cart-count" data-cart-render="item_count">0<span>
                            </a>
                            <!--Minicart Popup-->
                            <div id="header-cart" class="block block-cart">
                                <ul class="mini-products-list cart__row" id="cart-items">
                                    <!-- Cart items will be dynamically added here -->
                                </ul>

                                <div class="total">
                                    <div class="total-in">
                                        <span class="label">Total:</span>
                                        <span class="product-amount-mini">
                                            <span class="money" id="totalAmountMini" style="font-weight: 700; float: right"></span>
                                        </span>
                                    </div>

                                    <div class="buttonSet text-center">
                                        <a href="cart.php" class="btn btn-secondary btn--small">View Cart</a>
                                        <a href="checkout.php" class="btn btn-secondary btn--small" id="cartCheckout">Checkout</a>
                                    </div>
                                </div>
                            </div>
                            <!--End Minicart Popup-->
                        </div>
                        <div class="site-header__search">
                            <button type="button" class="search-trigger"><i class="icon anm anm-search-l"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End Header-->
        <!--Mobile Menu-->
        <div class="mobile-nav-wrapper" role="navigation">
            <div class="closemobileMenu"><i class="icon anm anm-times-l pull-right"></i> Close Menu</div>
            <ul id="MobileNav" class="mobile-nav">
                <li class="lvl1"><a href="index.php">Home</a></li>
                <li class="lvl1"><a href="about-us.php">About Us</a></li>
                <li class="lvl1"><a href="mechanics.php">Mechanics</a></li>
                <li class="lvl1 parent"><a href="#">Spare Parts <i class="anm anm-plus-l"></i></a>
                    <ul>
                        <?php
                        $query = "SELECT * FROM categories ORDER BY category_name ASC;";
                        $data = $controller->getRecords($query);
                        foreach ($data as $category) {
                            $categoryId = $category['category_id'];
                            $categoryName = $category['category_name'];
                        ?>
                            <li><a href="category-spare-parts.php?category=<?= $categoryId; ?>" class="site-nav"><?= $categoryName ?></a></li>
                        <?php } ?>
                    </ul>
                </li>
                <li class="lvl1 parent"><a href="#">Services <i class="anm anm-plus-l"></i></a>
                    <ul>
                        <li><a href="#" class="site-nav">Car Rentals</a></li>
                        <li><a href="#" class="site-nav">Transport Service</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!--End Mobile Menu-->

        <!--Body Content-->
        <div id="page-content">