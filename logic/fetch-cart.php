<?php
session_start();

if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    $cartData = $_SESSION['cart'];

    // Prepare an array to hold the formatted cart data
    $formattedCart = [];

    foreach ($cartData as $item) {
        $formattedItem = [
            'id' => $item['id'],
            'name' => $item['name'],
            'price' => $item['price'],
            'image' => $item['image'],
            'quantity' => $item['quantity'],
            'amount' => $item['price'] * $item['quantity']
        ];

        $formattedCart[] = $formattedItem;
    }


    // Return the formatted cart data in JSON format
    header('Content-Type: application/json');
    echo json_encode($formattedCart);
} else {
    // Return an empty JSON array if the cart is empty or doesn't exist
    header('Content-Type: application/json');
    echo json_encode([]);
}
