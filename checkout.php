<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
session_start();

// Error handler 
function errorHandler($errno, $errstr, $errfile, $errline)
{
    $eventDate = date("Y-M-d H:m:s");
    $message = "[$eventDate] - Error: [$errno] $errstr - $errfile:$errline";
    error_log($message . PHP_EOL, 3, "error-log.txt");
}

set_error_handler("errorHandler");

require_once 'controllers/storeController.php';
include_once('includes/head.php');
include_once('includes/navbar.php');

$controller = new storeController();
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
                        <h2 class="login-title mb-3">Billing details</h2>
                        <div class="row">
                            <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                <label for="input-firstname">First Name <span class="required-f">*</span></label>
                                <input name="firstname" id="input-firstname" type="text">
                            </div>
                            <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                <label for="input-lastname">Last Name <span class="required-f">*</span></label>
                                <input name="lastname" id="input-lastname" type="text">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                <label for="input-email">E-Mail <span class="required-f">*</span></label>
                                <input name="email" id="input-email" type="email">
                            </div>
                            <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                <label for="input-telephone">Contact <span class="required-f">*</span></label>
                                <input name="Contact" id="input-telephone" type="tel">
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <div class="row">
                            <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                <label for="input-address-1">GPS Address <span class="required-f">*</span></label>
                                <input name="address_1" id="input-address-1" type="text">
                            </div>
                            <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                <label for="input-city">City/Town <span class="required-f">*</span></label>
                                <input name="city" id="input-city" type="text">
                            </div>
                        </div>
                        <div class="row">
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
                                ?>
                                        <tr class="cart__row border-bottom line1 cart-flex border-top cart-item" data-product-id="<?= $item['id']; ?>">
                                            <td class="cart__image-wrapper cart-flex-item">
                                                <a href="#"><img class="cart__image" src="uploads/<?= $item['image']; ?>" alt="uploads/<?= $item['image']; ?>"></a>
                                            </td>
                                            <td class="cart__meta small--text-left cart-flex-item">
                                                <div class="list-view-item__title">
                                                    <a href="#"><?= $item['name']; ?></a>
                                                </div>
                                            </td>
                                            <td class="cart__price-wrapper cart-flex-item text-center product-price">
                                                <span class="money"><?= $item['price'] ?></span>
                                            </td>
                                            <td class="cart__update-wrapper cart-flex-item text-center product-quantity">
                                                <span class="money"><?= $item['quantity']; ?></span>
                                            </td>
                                            <td class="text-right small--hide cart-price text-center">
                                                <span class="money" id="amount"></span>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr class="empty-cart">
                                        <td colspan="5" class="text-center">
                                            <h1 class="text-danger" style="text-transform: uppercase;">Empty Cart</h1>
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

                <hr />

                <div class="your-payment">
                    <h2 class="payment-title mb-3">payment method</h2>
                    <div class="payment-method">
                        <div class="payment-accordion">
                            <div id="accordion" class="payment-section">
                                <div class="card mb-2">
                                    <div class="card-header">
                                        <a class="card-link" data-toggle="collapse" href="#collapseOne">MTN Mobile Money</a>
                                    </div>
                                    <div id="collapseOne" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                            <p class="no-margin font-15">Please enter your MTN Mobile Money Number</p>
                                            <fieldset>
                                                <div class="row">
                                                    <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                                        <label for="input-cardname">MoMo Number <span class="required-f">*</span></label>
                                                        <input name="momo-number" placeholder="Momo Number" id="input-momo-number" class="form-control rounded-0" type="number">
                                                    </div>
                                                    <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                                        <div class="order-button-payment">
                                                            <button class="btn" type="submit">Place order</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-2">
                                    <div class="card-header">
                                        <a class="card-link" data-toggle="collapse" href="#collapseTwo">Vodafone Cash</a>
                                    </div>
                                    <div id="collapseTwo" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                            <p class="no-margin font-15">Please enter your Vodafone Cash Number</p>
                                            <fieldset>
                                                <div class="row">
                                                    <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                                        <label for="input-cardname">Voda Cash Number <span class="required-f">*</span></label>
                                                        <input name="vcash-number" placeholder="Voda Cash Number" id="input-vcash-number" class="form-control rounded-0" type="number">
                                                    </div>
                                                    <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                                        <div class="order-button-payment">
                                                            <button class="btn" type="submit">Place order</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-2" hidden>
                                    <div class="card-header">
                                        <a class="collapsed card-link" data-toggle="collapse" href="#collapseThree"> Card Information </a>
                                    </div>
                                    <div id="collapseThree" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                            <fieldset>
                                                <div class="row">
                                                    <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                                        <label for="input-cardname">Name on Card <span class="required-f">*</span></label>
                                                        <input name="cardname" placeholder="Card Name" id="input-cardname" class="form-control" type="text">
                                                    </div>
                                                    <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                                        <label for="input-country">Credit Card Type <span class="required-f">*</span></label>
                                                        <select name="country_id" class="form-control">
                                                            <option> --- Please Select --- </option>
                                                            <option value="1">American Express</option>
                                                            <option value="2">Visa Card</option>
                                                            <option value="3">Master Card</option>
                                                            <option value="4">Discover Card</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                                        <label for="input-cardno">Credit Card Number <span class="required-f">*</span></label>
                                                        <input name="cardno" placeholder="Credit Card Number" id="input-cardno" class="form-control" type="text">
                                                    </div>
                                                    <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                                        <label for="input-cvv">CVV Code <span class="required-f">*</span></label>
                                                        <input name="cvv" placeholder="Card Verification Number" id="input-cvv" class="form-control" type="text">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                                        <label>Expiration Date <span class="required-f">*</span></label>
                                                        <input type="date" name="exdate" class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                                        <img class="padding-25px-top xs-padding-5px-top" src="assets/images/payment-img.jpg" alt="card" title="card" />
                                                    </div>
                                                </div>
                                            </fieldset>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once('includes/footer.php');
?>



