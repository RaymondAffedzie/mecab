<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['quantity'];

    $cart_item = [
        'id' => $product_id,
        'name' => $product_name,
        'price' => $product_price,
        'image' => $product_image,
        'quantity' => $product_quantity,
        'subtotal' => $product_price * $product_quantity
    ];

    // Initialize the cart if it doesn't exist 
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if the product already exists in the cart
    $product_index = -1;
    foreach ($_SESSION['cart'] as $index => $item) {
        if ($item['id'] === $product_id) {
            $product_index = $index;
            break;
        }
    }

    // If the product exists, update the quantity
    if ($product_index !== -1) {
        $_SESSION['cart'][$product_index]['quantity'] += $product_quantity;
        $_SESSION['cart'][$product_index]['subtotal'] += $cart_item['subtotal'];
    } else {
        $_SESSION['cart'][] = $cart_item;
    }

    // Calculate the total of all products in the cart
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['subtotal'];
    }

    // Store the total in a session variable for future use
    $_SESSION['cart_total'] = $total;

    echo 'success';
} else {
    echo 'error';
}


