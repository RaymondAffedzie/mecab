<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
session_start();

// Error handler 
function errorHandler($errno, $errstr, $errfile, $errline)
{
    $eventDate = date("Y-M-d H:i:s");
    $message = "[$eventDate] - Error: [$errno] $errstr - $errfile:$errline";
    error_log($message . PHP_EOL, 3, "error-log.txt");
}

set_error_handler("errorHandler");

// Prevent user from accessing this page when not logged in
if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn'] || $_SESSION['role'] != 'Customer') {
    header("Location: login.php");
    exit;
}

require_once 'controllers/storeController.php';
$controller = new storeController();
include_once('includes/head.php');
include_once('includes/navbar.php');

?> <!--Page Title-->
<div class="page section-header text-center">
    <div class="page-title">
        <div class="wrapper">
            <h1 class="page-width">Checkout</h1>
        </div>
    </div>
</div>
<!--End Page Title-->

<div class="container">
    <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
            <div class="customer-box returning-customer">
                <div id="customer-login" class="collapse customer-content">
                    <div class="customer-info">
                        <form>
                            <div class="row">
                                <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="exampleInputEmail1">Email address <span class="required-f">*</span></label>
                                    <input type="email" class="no-margin" id="exampleInputEmail1">
                                </div>
                                <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="exampleInputPassword1">Password <span class="required-f">*</span></label>
                                    <input type="password" id="exampleInputPassword1">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-check width-100 margin-20px-bottom">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input"> Remember me!
                                        </label>
                                        <a href="#" class="float-right">Forgot your password?</a>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
            <div class="customer-box customer-coupon">
                <div id="have-coupon" class="collapse coupon-checkout-content">
                    <div class="discount-coupon">
                        <div id="coupon" class="coupon-dec tab-pane active">
                            <p class="margin-10px-bottom">Enter your coupon code if you have one.</p>
                            <label class="required get" for="coupon-code"><span class="required-f">*</span> Coupon</label>
                            <input id="coupon-code" required="" type="text" class="mb-3">
                            <button class="coupon-btn btn" type="submit">Apply Coupon</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row billing-fields">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 sm-margin-30px-bottom">
            <div class="create-ac-content bg-light-gray padding-20px-all">
                <form>

                    <fieldset>
                        <div class="row">
                            <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                <label for="input-telephone">Contact <span class="required-f">*</span></label>
                                <input name="Contact" id="input-telephone" type="tel">
                            </div>
                            <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                <label for="input-address-1">GPS Address <span class="required-f">*</span></label>
                                <input name="address_1" id="input-address-1" type="text">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                <label for="input-city">City/Town <span class="required-f">*</span></label>
                                <input name="city" id="input-city" type="text">
                            </div>
                            <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                <label for="region">Region<span class="required-f">*</span></label>
                                <select name="region" id="input-zone">
                                    <option>Select Region</option>
                                    <option value="Ahafo">Ahafo</option>
                                    <option value="Ashanti">Ashanti</option>
                                    <option value="Bono">Bono</option>
                                    <option value="Bono East">Bono East</option>
                                    <option value="Central">Central</option>
                                    <option value="Eastern">Eastern</option>
                                    <option value="Greater Accra">Greater Accra</option>
                                    <option value="Northern">Northern</option>
                                    <option value="North East">North East</option>
                                    <option value="Oti">Oti</option>
                                    <option value="Savannah">Savannah</option>
                                    <option value="Upper East">Upper East</option>
                                    <option value="Upper West">Upper West</option>
                                    <option value="Volta">Volta</option>
                                    <option value="Western">Western</option>
                                    <option value="Western North">Western North</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12 col-lg-12 col-xl-12 required">
                                <label for="">Payment method<span class="required-f">*</span></label>
                            </div>
                            <div class="form-group col-md-12 col-lg-12 col-xl-12 required">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="payment-method" id="momo" value="momo" checked>
                                    <label class="form-check-label" for="momo">MTN Mobile Money (MoMo)</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="payment-method" id="voda-cash" value="voda-cash">
                                    <label class="form-check-label" for="voda-cash">Vodafone Cash (Voda Cash)</label>
                                </div>
                                <div class="mobile-money-qr-payment" 
                                    data-api-user-id="" 
                                    data-amount="" 
                                    data-currency="GHS" 
                                    data-external-id="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12 col-lg-12 col-xl-12">
                                <div class="order-button-payment">
                                    <button class="btn" type="submit">order</button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
            <div class="your-order-payment">
                <div class="your-order">
                    <h2 class="order-title mb-4">Your Order</h2>
                    <div class="table-responsive-sm order-table">
                        <table class="bg-white table table-borderless table-hover text-center">
                            <thead>
                                <tr>
                                    <th class="text-center">Product Image</th>
                                    <th class="text-center">Product Name</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-center">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                                    foreach ($_SESSION['cart'] as $item) {
                                        $itemAmount = $item['quantity'] * $item['price'];
                                ?>
                                        <tr class="cart__row  cart-item" data-product-id="<?= $item['id']; ?>">
                                            <td class="cart__image-wrapper cart-flex-item">
                                                <a href="#"><img class="cart__image" src="uploads/<?= $item['image']; ?>" alt="uploads/<?= $item['image']; ?>"></a>
                                            </td>
                                            <td class="text-center cart-flex-item">
                                                <div class="list-view-item__title">
                                                    <a href="#"><?= $item['name']; ?></a>
                                                </div>
                                            </td>
                                            <td class="text-center product-price">
                                                <span class="money">&#x20B5;<?= $item['price'] ?></span>
                                            </td>
                                            <td class=" text-center product-quantity">
                                                <span class="money"><?= $item['quantity']; ?></span>
                                            </td>
                                            <td class="text-center product-amount">
                                                <span class="money" id="amount"><b>&#x20B5;<?= $itemAmount; ?></b></span>
                                            </td>

                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr class="empty-cart">
                                        <td colspan="5" class="text-center">
                                            <h1 class="text-danger" style="text-transform: uppercase;">Your cart is empty</h1>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                            <tfoot class="font-weight-600">

                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once('includes/footer.php');
?>