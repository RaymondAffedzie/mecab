
<?php
session_start();

if (isset($_POST['clear'])) {
    unset($_SESSION['cart']); // Clear the cart session
    echo 'success'; // Return a success response
} else {
    echo 'error';
}
