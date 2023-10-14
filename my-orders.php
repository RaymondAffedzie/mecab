<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
session_start();

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

$query = "SELECT o.order_id, o.order_date, o.total_amount, o.status, count(i.order_id) AS order_items
FROM orders o
INNER JOIN order_items i ON o.order_id = i.order_id
WHERE customer_id = :customer
GROUP BY o.order_id, o.order_date, o.total_amount, o.status
ORDER BY o.order_date DESC;
";
$params = [':customer' => $_SESSION['userId']];
$myOrders = $controller->getRecordsByValue($query, $params);
?>


<div class="container my-5">
    <div class="p-5 text-center bg-body-tertiary rounded-5">
        <h1 class="text-body-emphasis">Orders</h1>
        <p class="lead">
            All your orders are listed on this page. Thank you for your time.
        </p>
    </div>
</div>

<div class="container">
    <div class="row justify-content-between"">
        <div class=" col-md-4">
        <h5 class="py-3">Orders History</h5>
        <?php
        foreach ($myOrders as $data) {
        ?>
            <div class="order-item border-bottom my-3 p-3 position-relative" data-order-id="<?= $data['order_id']; ?>">
                <h6 class="position-absolute mx-3 top-0 start-0"><?= $controller->formatDate($data['order_date']) . ' Order'; ?></h6>
                <p class="position-absolute top-0 end-0"><?= ucfirst($data['status']); ?></p>
                <p>&#x20B5;<?= $data['total_amount']; ?></p>
                <p><?= $data['order_items']; echo ($data['order_items'] === 1) ? ' Item' : ' Items'; ?></p>
            </div>
        <?php
        }
        ?>
    </div>

    <div class="col-md-7">
        <h5 class="py-3" id="orderNumber"></h5>
        
        <div id="order-details">
        </div>

        <div id="delivery-details">
        </div>
    </div>
</div>
</div>


<?php include_once('includes/footer.php'); ?>