<?php
session_start();

if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    $totalItemsInCart = count($_SESSION['cart']);
    echo json_encode(['count' => $totalItemsInCart]);
} else {
    echo json_encode(['count' => 0]);
}