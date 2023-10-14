<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];

    if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['id'] == $product_id) {
                unset($_SESSION['cart'][$key]);
                // Recalculate the cart total
                $total = 0;
                foreach ($_SESSION['cart'] as $cartItem) {
                    $total += $cartItem['subtotal'];
                }
                $_SESSION['cart_total'] = $total;
                echo 'success';
                exit;
            }
        }
    }
}

echo 'error';
?>
