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
?>


<!--Page Title-->
<div class="page section-header text-center">
    <div class="page-title">
        <div class="wrapper">
            <h1 class="page-width">Your Shopping Cart</h1>
        </div>
    </div>
</div>
<!--End Page Title-->

<div class="container">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 main-col">

            <form action="#" method="post" class="cart style2">
                <table id="cartTable" class="table">
                    <thead class="cart__row cart__header">
                        <tr>
                            <th colspan="2" class="text-center">Product</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Remove</th>
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
                                    <td class="text-left small--hide text-center">
                                        <a href="#" class="btn btn--secondary cart__remove" title="Remove item" data-product-id="<?= $item['id']; ?>">
                                            <i class="icon icon anm anm-times-l"></i>
                                        </a>
                                    </td>

                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr class="empty-cart">
                                <td colspan="6" class="text-center">
                                    <h1 class="text-danger" style="text-transform: uppercase;">Empty Cart</h1>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6" class="text-left">
                                <button type="submit" id="clearCartBtn" class="btn btn-secondary btn--small small--hide float-right">Clear Cart</button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>

        <div class="container mt-4">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 mb-4" hidden>
                    <h5>Discount Codes</h5>
                    <form action="#" method="post">
                        <div class="form-group">
                            <label for="address_zip">Enter your coupon code if you have one.</label>
                            <input type="text" name="coupon">
                        </div>
                        <div class="actionRow">
                            <div><input type="button" class="btn btn-secondary btn--small" value="Apply Coupon"></div>
                        </div>
                    </form>
                </div>

                <div class="col-12 col-sm-12 col-md-4 col-lg-4 cart__footer">
                    <div class="solid-border">
                        <div class="row border-bottom pb-2">
                            <span class="col-12 col-sm-6 cart__subtotal-title">Subtotal</span>
                            <span class="col-12 col-sm-6 text-right">
                                <span class="money sub-total"></span>
                            </span>
                        </div>

                        <div class="row border-bottom pb-2 pt-2" hidden>
                            <span class="col-12 col-sm-6 cart__subtotal-title">
                                <strong>Grand Total</strong>
                            </span>
                            <span class="col-12 col-sm-6 cart__subtotal-title cart__subtotal text-right">
                                <span class="money grand-total"></span>
                            </span>
                        </div>
                        <p class="cart_tearm pt-3">
                            <label for="tnc">
                                <input type="checkbox" id="tnc" name="tnc" class="checkbox" value="tearm" required="">
                                I agree with the <a href="#">terms</a> and <a href="#">conditions</a>
                            </label>
                        </p>
                        <input type="submit" name="checkout" id="cartCheckout" class="btn btn--small-wide checkout" value="Proceed To Checkout">
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>


<?php
include_once('includes/footer.php')
?>