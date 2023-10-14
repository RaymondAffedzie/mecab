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

require_once 'controllers/storeController.php';
$controller = new storeController();
include_once('includes/head.php');
include_once('includes/navbar.php');
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
            <div class="table-responsive">
                <table id="cartTable" class="table">
                    <thead class="">
                        <tr>
                            <th class="text-center">Image</th>
                            <th class="text-center">Product Name</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Remove</th>
                        </tr>
                    </thead>
                    <tbody> 
                        <?php
                        $totalAmount = 0;
                        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                            foreach ($_SESSION['cart'] as $item) {
                                $itemAmount = $item['quantity'] * $item['price'];
                                $totalAmount += $itemAmount; 
                        ?>
                                <tr class="cart__row  cart-item" data-product-id="<?= $item['id']; ?>">
                                    <td class="cart__image-wrapper cart-flex-item">
                                        <img class="cart__image" src="uploads/<?= $item['image']; ?>" alt="<?= $item['name']; ?>">
                                    </td>
                                    <td class="text-center cart-flex-item">
                                        <div class="list-view-item__title">
                                            <span><?= $item['name']; ?></span>
                                        </div>
                                    </td>
                                    <td class="text-center product-price">
                                        <span class="money">&#x20B5;<?=  $item['price'] ?></span>
                                    </td>
                                    <td class=" text-center product-quantity">
                                        <span class="money"><?= $item['quantity']; ?></span>
                                    </td>
                                    <td class="text-center product-amount">
                                        <span class="money" id="amount"><b>&#x20B5;<?= $itemAmount; ?></b></span>
                                    </td>
                                    <td class="text-left text-center">
                                        <a href="#" class="btn btn--secondary cart__remove" title="Remove item" data-product-id="<?= $item['id']; ?>">
                                            <i class="ti-close"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr class="empty-cart">
                                <td colspan="6" class="text-center">
                                    <h1 class="text-danger" style="text-transform: uppercase;">Your cart is empty</h1>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">
                                <h2 class="text-right">Total</h2>
                            </td>
                            <td class="text-center">
                                <h2 id="totalAmount"></h2>
                            </td>
                            <td class="text-left">
                                <a href="checkout.php" class="btn btn-secondary btn--small" id="cartCheckout">Checkout</a>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>


<?php
include_once('includes/footer.php')
?>