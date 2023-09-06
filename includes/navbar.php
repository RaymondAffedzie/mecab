<body class="template-index home13-auto-parts">
    <div class="pageWrapper">
        <!--Search Form Drawer-->
        <div class="search">
            <div class="search__form">
                <form class="search-bar__form" action="#">
                    <button class="go-btn search__button" type="submit"><i class="icon anm anm-search-l"></i></button>
                    <input class="search__input" type="search" name="q" value="" placeholder="Search entire store..." aria-label="Search" autocomplete="off">
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
                        <p class="phone-no"><i class="anm anm-phone-s"></i> +233 (0)24 769 2388 / +233 (0)24 816 5601</p>
                    </div>
                    <div class="col-sm-4 col-md-4 col-lg-4 d-none d-lg-none d-md-block d-lg-block">
                        <div class="text-center"><p class="top-header_middle-text">iRBbA Devs & iQuco Tech</p></div>
                    </div>
                    <div class="col-2 col-sm-4 col-md-3 col-lg-4 text-right">
                        <span class="user-menu d-block d-lg-none"><i class="anm anm-user-al" aria-hidden="true"></i></span>
						<?php
							if (isset($_SESSION['loggedIn'])) {
							?>
							<ul class="customer-links list-inline">
								<li>
									<form id="logoutForm" action="./logic/logout.php" method="post">
										<button type="submit" name="logout" class="border-0 text-light" style="cursor: pointer;">
											<i class="ti-power-off text-primary"></i> Logout
										</button>
									</form>
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
                                    <li class="lvl1 parent dropdown"><a href="#">Shops <i class="anm anm-angle-down-l"></i></a>
                                        <ul class="dropdown">
                                            <li><a href="#" class="site-nav">Mechanic</a></li>
                                            <li><a href="spare-parts.html" class="site-nav">Spare Parts</a></li>
                                            <li><a href="#" class="site-nav">Car Rentals</a></li>
                                            <li><a href="#" class="site-nav">Transport Service</a></li>
                                            <li><a href="#" class="site-nav">FAQs</a></li>
                                        </ul>
                                    </li>
                                    <li class="lvl1 parent megamenu"><a href="#">Products <i class="anm anm-angle-down-l"></i></a>
                                        <div class="megamenu style2">
                                            <ul class="grid mmWrapper">
                                                <li class="grid__item one-whole">
                                                    <ul class="grid">
                                                        <li class="grid__item lvl-1 col-md-3 col-lg-3"><a href="#" class="site-nav lvl-1">Spare Parts Products</a>
                                                            <ul class="subLinks">
                                                                <li class="lvl-2"><a href="#" class="site-nav lvl-2">Product 1</a></li>
                                                                <li class="lvl-2"><a href="#" class="site-nav lvl-2">Product 2</a></li>
                                                            </ul>
                                                        </li>
                                                        <li class="grid__item lvl-1 col-md-3 col-lg-3"><a href="#" class="site-nav lvl-1">Auto Mecahnic Services</a>
                                                            <ul class="subLinks">
                                                                <li class="lvl-2"><a href="#" class="site-nav lvl-2">Service 1</a></li>
                                                                <li class="lvl-2"><a href="#" class="site-nav lvl-2">Service 2</a></li>
                                                            </ul>
                                                        </li>
                                                        <li class="grid__item lvl-1 col-md-3 col-lg-3"><a href="#" class="site-nav lvl-1">Transport Servies</a>
                                                            <ul class="subLinks">
                                                                <li class="lvl-2"><a href="#" class="site-nav lvl-2">Service 1</a></li>
                                                                <li class="lvl-2"><a href="#" class="site-nav lvl-2">Service 2</a></li>
                                                            </ul>
                                                        </li>
                                                        <li class="grid__item lvl-1 col-md-3 col-lg-3"><a href="#" class="site-nav lvl-1">Car Rental Services</a>
                                                            <ul class="subLinks">
                                                                <li class="lvl-2"><a href="#" class="site-nav lvl-2">Service 1</a></li>
                                                                <li class="lvl-2"><a href="#" class="site-nav lvl-2">Service 2</a></li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="lvl1 parent dropdown"><a href="#">Blog <i class="anm anm-angle-down-l"></i></a>
                                        <ul class="dropdown">
                                            <li><a href="blog-grid-view.html" class="site-nav">All blogs</a></li>
                                            <li><a href="blog-article.html" class="site-nav">Read Article</a></li>
                                        </ul>
                                    </li>
                                    <li class="lvl1"><a href="about-us.html">About Us<i class="anm anm-angle-down-l"></i></a></li>
                                    <li class="lvl1"><a href="contact-us.html">Contact Us<i class="anm anm-angle-down-l"></i></a></li>
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
                                <span id="CartCount" class="site-header__cart-count" data-cart-render="item_count">2</span>
                            </a>
                            <!--Minicart Popup-->
                            <div id="header-cart" class="block block-cart">
                                <ul class="mini-products-list">
                                    <li class="item">
                                        <a class="product-image" href="#">
                                            <img src="assets/images/product-images/cape-dress-1.jpg" alt="3/4 Sleeve Kimono Dress" title="" />
                                        </a>
                                        <div class="product-details">
                                            <a href="#" class="remove"><i class="anm anm-times-l" aria-hidden="true"></i></a>
                                            <a href="#" class="edit-i remove"><i class="anm anm-edit" aria-hidden="true"></i></a>
                                            <a class="pName" href="cart.html">Sleeve Kimono Dress</a>
                                            <div class="variant-cart">Black / XL</div>
                                            <div class="wrapQtyBtn">
                                                <div class="qtyField">
                                                    <span class="label">Qty:</span>
                                                    <a class="qtyBtn minus" href="javascript:void(0);"><i class="fa anm anm-minus-r" aria-hidden="true"></i></a>
                                                    <input type="text" id="Quantity" name="quantity" value="1" class="product-form__input qty">
                                                    <a class="qtyBtn plus" href="javascript:void(0);"><i class="fa anm anm-plus-r" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                            <div class="priceRow">
                                                <div class="product-price">
                                                    <span class="money">$59.00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <div class="total">
                                    <div class="total-in">
                                        <span class="label">Cart Subtotal:</span><span class="product-price"><span class="money">$748.00</span></span>
                                    </div>
                                    <div class="buttonSet text-center">
                                        <a href="cart.php" class="btn btn-secondary btn--small">View Cart</a>
                                        <a href="checkout.html" class="btn btn-secondary btn--small">Checkout</a>
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
                <li class="lvl1 parent megamenu"><a href="#">Shops <i class="anm anm-plus-l"></i></a>
                    <ul>
                        <li><a href="#" class="site-nav">Mecahnic</a></li>
                        <li><a href="spare-parts.html" class="site-nav">Spare Parts</a></li>
                        <li><a href="#" class="site-nav">Car Rentals</a></li>
                        <li><a href="#" class="site-nav">Transport Services</a></li>
                        <li><a href="#" class="site-nav">FAQs</a></li>
                    </ul>
                </li>
                <li class="lvl1 parent megamenu"><a href="#">Products <i class="anm anm-plus-l"></i></a>
                    <ul>
                        <li><a href="#" class="site-nav">Spare Part Products<i class="anm anm-plus-l"></i></a>
                            <ul>
                                <li><a href="product-layout-1.html" class="site-nav">Product Layout 1</a></li>
                                <li><a href="product-layout-2.html" class="site-nav">Product Layout 2</a></li>
                            </ul>
                        </li>
                        <li><a href="#" class="site-nav">Auto Mechanic Servies<i class="anm anm-plus-l"></i></a>
                            <ul>
                                <li><a href="short-description.html" class="site-nav">Short Description</a></li>
                                <li><a href="product-countdown.html" class="site-nav">Product Countdown</a></li>
                            </ul>
                        </li>
                        <li><a href="#" class="site-nav">Transport Services<i class="anm anm-plus-l"></i></a>
                            <ul>
                                <li><a href="product-accordion.html" class="site-nav">Product Accordion</a></li>
                                <li><a href="product-pre-orders.html" class="site-nav">Product Pre-orders </a></li>
                            </ul>
                        </li>
                        <li><a href="#" class="site-nav">Car Rentals Services<i class="anm anm-plus-l"></i></a>
                            <ul>
                                <li><a href="product-with-variant-image.html" class="site-nav">Product with Variant Image</a></li>
                                <li><a href="product-with-color-swatch.html" class="site-nav">Product with Color Swatch</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="lvl1 parent megamenu"><a href="blog-left-sidebar.html">Blog <i class="anm anm-plus-l"></i></a>
                    <ul>
                        <li><a href="blog-grid-view.html" class="site-nav">Gridview</a></li>
                        <li><a href="blog-article.html" class="site-nav">Article</a></li>
                    </ul>
                </li>
                <li class="lvl1"><a href="about-us.html"> <b>About Us</b></a></li>
                <li class="lvl1"><a href="contact-us.html"><b>Contact Us</b></a></li>
            </ul>
        </div>
        <!--End Mobile Menu-->
    
    <!--Body Content-->
    <div id="page-content">