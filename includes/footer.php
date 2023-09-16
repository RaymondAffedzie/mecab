        <!--Footer-->
        </div>
        <footer id="footer">
            <div class="newsletter-section">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-7 w-100 d-flex justify-content-start align-items-center">
                            <div class="display-table">
                                <div class="display-table-cell footer-newsletter">
                                    <div class="section-header text-center">
                                        <label class="h2"><span>sign up for </span>newsletter</label>
                                    </div>
                                    <form action="#" method="post">
                                        <div class="input-group">
                                            <input type="email" class="input-group__field newsletter__input" name="EMAIL" value="" placeholder="Email address" required="" disabled>
                                            <span class="input-group__btn">
                                                <button type="submit" class="btn newsletter__submit" name="commit" id="Subscribe" disabled><span class="newsletter__submit-text--large">Subscribe</span></button>
                                            </span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-5 d-flex justify-content-end align-items-center">
                            <div class="footer-social">
                                <ul class="list--inline site-footer__social-icons social-icons">
                                    <li><a class="social-icons__link" href="#" target="_blank" title="Follow MeCAB on Facebook"><i class="icon icon-facebook"></i> <span class="icon__fallback-text">Facebook</span></a></li>
                                    <li><a class="social-icons__link" href="#" target="_blank" title="Follow MeCAB on Twitter"><i class="icon icon-twitter"></i> <span class="icon__fallback-text">Twitter</span></a></li>
                                    <li><a class="social-icons__link" href="#" target="_blank" title="Follow MeCAB on Instagram"><i class="icon icon-instagram"></i> <span class="icon__fallback-text">Instagram</span></a></li>
                                    <li><a class="social-icons__link" href="#" target="_blank" title="Subscribe to our YouTube channel"><i class="icon icon-youtube"></i> <span class="icon__fallback-text">YouTube</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="site-footer">
                <div class="container">
                    <!--Footer Links-->
                    <div class="footer-top">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-3 col-lg-3 footer-links">
                                <h4 class="h4">Quick Shop</h4>
                                <ul>
                                    <li><a href="#">Spare Parts</a></li>
                                    <li><a href="#">Mechanic</a></li>
                                    <li><a href="#">Car Rentals</a></li>
                                    <li><a href="#">Transport Management</a></li>
                                </ul>
                            </div>
                            <div class="col-12 col-sm-12 col-md-3 col-lg-3 footer-links">
                                <h4 class="h4">Informations</h4>
                                <ul>
                                    <li><a href="#">About us</a></li>
                                    <li><a href="#">Careers</a></li>
                                    <li><a href="#">Privacy policy</a></li>
                                    <li><a href="terms-and-conditions.php">Terms &amp; condition</a></li>
                                    <li><a href="#">My Account</a></li>
                                </ul>
                            </div>
                            <div class="col-12 col-sm-12 col-md-3 col-lg-3 footer-links">
                                <h4 class="h4">Customer Services</h4>
                                <ul>
                                    <!-- <li><a href="#">Request Personal Data</a></li> -->
                                    <li><a href="#">FAQ's</a></li>
                                    <li><a href="#">Contact Us</a></li>
                                    <li><a href="#">Orders and Returns</a></li>
                                    <li><a href="#">Support Center</a></li>
                                </ul>
                            </div>
                            <div class="col-12 col-sm-12 col-md-3 col-lg-3 contact-box">
                                <h4 class="h4">Contact Us</h4>
                                <ul class="addressFooter">
                                    <!-- <li>
                                        <i class="icon anm anm-map-marker-al"></i>
                                        <p>Commercial Road, A003 <br> CE-001-2923, Winneba</p>
                                    </li> -->
                                    <li class="phone"><i class="icon anm anm-phone-s"></i>
                                        <p>+233 (0) 24 479 1855</p>
                                    </li>
                                    <li class="email"><i class="icon anm anm-envelope-l"></i>
                                        <p>admin@mecab.org</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--End Footer Links-->
                    <hr>
                    <div class="footer-bottom">
                        <div class="row">
                            <!--Footer Copyright-->
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 order-1 order-md-0 order-lg-0 order-sm-1 copyright text-sm-center text-md-left text-lg-left">
                                <span></span>
                                <a href="#">Copyright © <?= date("Y") ?> MeCAB. All rights reserved.</a>
                            </div>
                            <!--End Footer Copyright-->
                            <!--Footer Payment Icon-->
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 order-0 order-md-1 order-lg-1 order-sm-0 payment-icons text-right text-md-center">
                                <!-- <ul class="payment-icons list--inline">
                                    <li><i class="icon fa fa-cc-visa" aria-hidden="true"></i></li>
                                    <li><i class="icon fa fa-cc-mastercard" aria-hidden="true"></i></li>
                                    <li><i class="icon fa fa-cc-paypal" aria-hidden="true"></i></li>
                                </ul> -->
                            </div>
                            <!--End Footer Payment Icon-->
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!--End Footer-->

        <!--Scoll Top-->
        <span id="site-scroll"><i class="icon anm anm-angle-up-r"></i></span>
        <!--End Scoll Top-->

        <!--Quick View popup-->
        <div class="modal fade quick-view-popup" id="content_quickview">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div id="ProductSection-product-template" class="product-template__container prstyle1">
                            <div class="product-single">
                                <!-- Start model close -->
                                <a href="javascript:void()" data-dismiss="modal" class="model-close-btn pull-right" title="close"><span class="icon icon anm anm-times-l"></span></a>
                                <!-- End model close -->
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="product-details-img">
                                            <div class="pl-20">
                                                <img src="assets/images/product-detail-page/camelia-reversible-big1.jpg" alt="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="product-single__meta">
                                            <h2 class="product-single__title">Product Quick View Popup</h2>
                                            <div class="prInfoRow">
                                                <div class="product-stock"> <span class="instock ">In Stock</span> <span class="outstock hide">Unavailable</span> </div>
                                                <div class="product-sku">SKU: <span class="variant-sku">19115-rdxs</span></div>
                                            </div>
                                            <p class="product-single__price product-single__price-product-template">
                                                <span class="visually-hidden">Regular price</span>
                                                <s id="ComparePrice-product-template"><span class="money">$600.00</span></s>
                                                <span class="product-price__price product-price__price-product-template product-price__sale product-price__sale--single">
                                                    <span id="ProductPrice-product-template"><span class="money">$500.00</span></span>
                                                </span>
                                            </p>
                                            <div class="product-single__description rte">
                                                Belle Multipurpose Bootstrap 4 Html Template that will give you and your customers a smooth shopping experience which can be used for various kinds of stores such as fashion,...
                                            </div>

                                            <form method="post" action="http://annimexweb.com/cart/add" id="product_form_10508262282" accept-charset="UTF-8" class="product-form product-form-product-template hidedropdown" enctype="multipart/form-data">
                                                <div class="swatch clearfix swatch-0 option1" data-option-index="0">
                                                    <div class="product-form__item">
                                                        <label class="header">Color: <span class="slVariant">Red</span></label>
                                                        <div data-value="Red" class="swatch-element color red available">
                                                            <input class="swatchInput" id="swatch-0-red" type="radio" name="option-0" value="Red">
                                                            <label class="swatchLbl color medium rectangle" for="swatch-0-red" style="background-image:url(assets/images/product-detail-page/variant1-1.jpg);" title="Red"></label>
                                                        </div>
                                                        <div data-value="Blue" class="swatch-element color blue available">
                                                            <input class="swatchInput" id="swatch-0-blue" type="radio" name="option-0" value="Blue">
                                                            <label class="swatchLbl color medium rectangle" for="swatch-0-blue" style="background-image:url(assets/images/product-detail-page/variant1-2.jpg);" title="Blue"></label>
                                                        </div>
                                                        <div data-value="Green" class="swatch-element color green available">
                                                            <input class="swatchInput" id="swatch-0-green" type="radio" name="option-0" value="Green">
                                                            <label class="swatchLbl color medium rectangle" for="swatch-0-green" style="background-image:url(assets/images/product-detail-page/variant1-3.jpg);" title="Green"></label>
                                                        </div>
                                                        <div data-value="Gray" class="swatch-element color gray available">
                                                            <input class="swatchInput" id="swatch-0-gray" type="radio" name="option-0" value="Gray">
                                                            <label class="swatchLbl color medium rectangle" for="swatch-0-gray" style="background-image:url(assets/images/product-detail-page/variant1-4.jpg);" title="Gray"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="swatch clearfix swatch-1 option2" data-option-index="1">
                                                    <div class="product-form__item">
                                                        <label class="header">Size: <span class="slVariant">XS</span></label>
                                                        <div data-value="XS" class="swatch-element xs available">
                                                            <input class="swatchInput" id="swatch-1-xs" type="radio" name="option-1" value="XS">
                                                            <label class="swatchLbl medium rectangle" for="swatch-1-xs" title="XS">XS</label>
                                                        </div>
                                                        <div data-value="S" class="swatch-element s available">
                                                            <input class="swatchInput" id="swatch-1-s" type="radio" name="option-1" value="S">
                                                            <label class="swatchLbl medium rectangle" for="swatch-1-s" title="S">S</label>
                                                        </div>
                                                        <div data-value="M" class="swatch-element m available">
                                                            <input class="swatchInput" id="swatch-1-m" type="radio" name="option-1" value="M">
                                                            <label class="swatchLbl medium rectangle" for="swatch-1-m" title="M">M</label>
                                                        </div>
                                                        <div data-value="L" class="swatch-element l available">
                                                            <input class="swatchInput" id="swatch-1-l" type="radio" name="option-1" value="L">
                                                            <label class="swatchLbl medium rectangle" for="swatch-1-l" title="L">L</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Product Action -->
                                                <div class="product-action clearfix">
                                                    <div class="product-form__item--quantity">
                                                        <div class="wrapQtyBtn">
                                                            <div class="qtyField">
                                                                <a class="qtyBtn minus" href="javascript:void(0);"><i class="fa anm anm-minus-r" aria-hidden="true"></i></a>
                                                                <input type="text" id="Quantity" name="quantity" value="1" class="product-form__input qty">
                                                                <a class="qtyBtn plus" href="javascript:void(0);"><i class="fa anm anm-plus-r" aria-hidden="true"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="product-form__item--submit">
                                                        <button type="button" name="add" class="btn product-form__cart-submit">
                                                            <span>Add to cart</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- End Product Action -->
                                            </form>
                                            <div class="display-table shareRow">
                                                <div class="display-table-cell">
                                                    <div class="wishlist-btn">
                                                        <a class="wishlist add-to-wishlist" href="#" title="Add to Wishlist"><i class="icon anm anm-heart-l" aria-hidden="true"></i> <span>Add to Wishlist</span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--End-product-single-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End Quick View popup-->

        <!-- Including Jquery -->
        <script src="assets/js/vendor/jquery-3.3.1.min.js"></script>
        <script src="assets/js/vendor/modernizr-3.6.0.min.js"></script>
        <script src="assets/js/vendor/jquery.cookie.js"></script>
        <script src="assets/js/vendor/wow.min.js"></script>
        <!-- Including Javascript -->
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/plugins.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/lazysizes.js"></script>
        <script src="assets/js/main.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function() {
                // user logout
                $('#logoutForm').submit(function(e) {
                    e.preventDefault(); // Prevent the default form submission

                    // Perform the Ajax request
                    $.ajax({
                        url: "./logic/logout.php",
                        type: "POST",
                        data: $("#logoutForm").serialize() + "&action=logout",
                        dataType: "json",
                        success: function(response) {
                            // Handle the response from the server
                            if (response.status === 'success') {
                                // If logout was successful, redirect to the login page
                                window.location.href = response.redirect;
                            } else {
                                // If there was an error, display the error message
                                swal("Error", response.message, "error");
                            }
                        },
                        error: function(xhr, status, error) {
                            // If there was an error with the Ajax request, display an error message
                            swal("Error", response.message, "error");
                        }
                    });
                });

                // add to shopping cart script
                $('#addToCartBtn').click(function() {
                    // Get the values from the input fields
                    var productId = $('#product_id').val();
                    var productName = $('#product_name').val();
                    var productPrice = parseFloat($('#product_price').val());
                    var productImage = $('#product_image').val();
                    var quantity = parseInt($('.quantity-input').val());

                    var data = {
                        product_id: productId,
                        product_name: productName,
                        product_image: productImage,
                        product_price: productPrice,
                        quantity: quantity
                    };

                    $.ajax({
                        type: 'POST',
                        url: 'logic/add-to-cart.php',
                        data: data,
                        success: function(response) {
                            alert('Item added to cart successfully');
                            updateSubtotal();
                        },
                        error: function(xhr, status, error) {
                            alert('Error adding item to cart');
                        }
                    });
                });

                // Calculate amount for an item
                function calculateItemAmount(row) {
                    var quantity = parseFloat($(row).find('.product-quantity').text());
                    var price = parseFloat($(row).find('.product-price').text());

                    // Check if quantity and price are valid numbers
                    if (!isNaN(quantity) && !isNaN(price)) {
                        return quantity * price;
                    } else {
                        return 0;
                    }
                }

                // Function to remove an item from the cart
                function removeItemFromCart(productId) {
                    $.ajax({
                        type: 'POST',
                        url: 'logic/remove-from-cart.php',
                        data: {
                            product_id: productId
                        },
                        success: function(response) {
                            if (response === 'success') {
                                $('tr[data-product-id="' + productId + '"]').remove();
                                updateSubtotal();
                                Swal.fire('Removed!', 'Item has been removed from the cart.', 'success');
                            } else {
                                Swal.fire('Error!', 'An error occurred while removing the item.', 'error');
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error!', 'An error occurred while communicating with the server.', 'error');
                        }
                    });
                }

                // Remove item from cart script
                $(document).on('click', '.cart__remove', function(e) {
                    e.preventDefault(); // Prevent the default link behavior
                    var productId = $(this).data('product-id');
                    Swal.fire({
                        title: 'Remove Item',
                        text: 'Are you sure you want to remove this item from the cart?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, remove it!',
                        cancelButtonText: 'Cancel',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (result.isConfirmed) {
                                removeItemFromCart(productId);
                            }
                        }
                    });
                });

                // Clear cart script
                $('#clearCartBtn').click(function(e) {
                    e.preventDefault(); // Prevent the default form submission behavior
                    Swal.fire({
                        title: 'Clear Cart',
                        text: 'Are you sure you want to clear the cart?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, clear it!',
                        cancelButtonText: 'Cancel',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            clearCart();
                        }
                    });
                });

                // Function to clear the cart
                function clearCart() {
                    $.ajax({
                        type: 'POST',
                        url: 'logic/clear-cart.php',
                        success: function(response) {

                            // Clear the table row content
                            $('#cartTable tbody').empty();

                            updateSubtotal();
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error!', 'An error occurred while clearing the cart.', 'error');
                        }
                    });
                }

                // Function to fetch and update the cart
                function fetchCart() {
                    $.ajax({
                        url: 'logic/fetch-cart.php',
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            // Update the cart on the page based on the data
                            updateCartItems(data);
                            updateSubtotal(); // Update the subtotal after fetching cart data
                        },
                        error: function() {
                            swal("Error", "Error fetching cart data!", "error");
                        }
                    });
                }

                // Function to update the cart items
                function updateCartItems(cartData) {
                    var cartItemsHtml = '';
                    $.each(cartData, function(index, item) {
                        var cartItemHtml = '<li class="item">';
                        cartItemHtml += '<a class="product-image" href="#"><img src="uploads/' + item.image + '" alt="" /></a>';
                        cartItemHtml += '<div class="product-details">';
                        cartItemHtml += '<a href="#" class="cart__remove float-right" data-product-id="' + item.id + '"><i class="anm anm-times-l" aria-hidden="true"></i></a>';
                        cartItemHtml += '<a class="pName" href="#"><h3>' + item.name + '</h3></a>';
                        cartItemHtml += '<div class="priceRow"><div class="product-price"><span class="money"><em>Item price: &#x20B5;' + item.price + '</em></span></div></div>';
                        cartItemHtml += '<div class="wrapQtyBtn"><div class="qtyField"><span class="label">Qty: ' + item.quantity + '</span></div></div>';
                        cartItemHtml += '<div class="amountRow"><div class="product-amount"><span class="money" id="amount"><b>Amount: &#x20B5;' + (item.amount).toFixed(2) + '</b></span></div></div>';
                        cartItemHtml += '</div></li>';
                        cartItemsHtml += cartItemHtml;
                    });

                    // Update the cart items in the HTML
                    $('#cart-items').html(cartItemsHtml);
                }

                // Initial fetch of the cart when the page loads
                fetchCart();

                // Periodic updates by calling fetchCart() on a timer (adjust the interval as needed)
                setInterval(fetchCart, 5000);

                function calculateTotalAmount() {
                    var totalAmount = 0;
                    $('.cart__row').each(function(index, row) {
                        var itemAmount = parseFloat($(row).find('.product-amount .money').text().replace('Amount: &#x20B5;', '').trim());
                        if (!isNaN(itemAmount)) {
                            totalAmount += itemAmount;
                        }
                    });
                    return totalAmount;
                }

                // Function to update the subtotal
                function updateSubtotal() {
                    var totalAmount = calculateTotalAmount();
                    var formattedTotal = '₵' + totalAmount.toFixed(2);
                    
                    $('.sub-total').text(formattedTotal);

                    if (totalAmount > 0) {
                        $('#cartCheckout').prop('disabled', false);
                    } else {
                        $('#cartCheckout').prop('disabled', true);
                    }
                }

                // Initial update of the subtotal when the page loads
                updateSubtotal();

            });

            // Items (Spare part) quanity adjustment
            document.addEventListener("DOMContentLoaded", function() {
                // Plus button click event
                var plusButtons = document.querySelectorAll(".qtyBtn.plus");
                plusButtons.forEach(function(button) {
                    button.addEventListener("click", function(e) {
                        e.preventDefault();
                        var input = this.previousElementSibling;
                        var value = parseInt(input.value);
                        input.value = value + 1;
                    });
                });

                // Minus button click event
                var minusButtons = document.querySelectorAll(".qtyBtn.minus");
                minusButtons.forEach(function(button) {
                    button.addEventListener("click", function(e) {
                        e.preventDefault();
                        var input = this.nextElementSibling;
                        var value = parseInt(input.value);
                        if (value > 1) {
                            input.value = value - 1;
                        }
                    });
                });
            });
        </script>
        </div>
        </body>

        </html>