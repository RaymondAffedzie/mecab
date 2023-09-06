<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
session_start();
// Error handler 
function errorHandler($errno, $errstr, $errfile, $errline)
{
	$eventDate = date("Y-M-d H:m:s");
	$message = "[$eventDate] - Error: [$errno] $errstr - $errfile:$errline";
	error_log($message . PHP_EOL, 3, "../error-log.txt");
}

set_error_handler("errorHandler");

// Prevent user from accessing this page when not logged in
if (!isset($_SESSION['loggedIn']) && !$_SESSION['loggedIn']) {
    header("Location: login.php");
    exit;
}

require_once '../controllers/storeController.php';
$controller = new storeController();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["category_id"]) && !empty($_POST["category_id"])) {
        $category_id = $_POST["category_id"];
        $table = 'categories';
        $column = 'category_id';

        // Delete the spare part record along with its image
        $deletedStatus = $controller->deleteRecordWithImage($table, $column, $category_id);

        switch ($deletedStatus) {
            case true:
                $response = array(
                    'status' => 'success',
                    'message' => 'Category deleted successfully.',
                    'redirect' => '../Admin/view-categories.php'
                );
                break;
            case 'not-existing':
                $response = array(
                    'status' => 'error',
                    'message' => 'Category not found.',
                    'redirect' => '../../Admin/view-categories.php'
                );
                break;
            case 'Failed':
                $response = array(
                    'status' => 'error',
                    'message' => 'An error occurred while deleting. Failed to delete the image.',
                    'redirect' => '../Admin/category-details.php'
                );
                break;
            default:
                $response = array(
                    'status' => 'error',
                    'message' => 'An error occurred while deleting.',
                    'redirect' => '../Admin/category-details.php'
                );
                break;
        }
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Invalid request. Missing category parameter.',
            'redirect' => '../Admin/view-categories.php'
        );
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Invalid request method.',
        'redirect' => '../Admin/view-categories.php'
    );
}

if (!headers_sent()) {
    echo json_encode($response);
}
?>
