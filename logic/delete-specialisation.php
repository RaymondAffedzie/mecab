<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
session_start();
// Error handler 
function errorHandler($errno, $errstr, $errfile, $errline)
{
	$eventDate = date("Y-M-d H:i:s");
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

    if (isset($_POST["specialisation"]) && !empty($_POST["specialisation"])) {
        $specialisation_ID =  filter_input(INPUT_POST, 'specialisation', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $table = 'specialisation';
        $column = 'specialisation_ID';

        // Delete the spare part record along with its image
        $deletedStatus = $controller->deleteRecordWithImage($table, $column, $specialisation_ID);

        switch ($deletedStatus) {
            case true:
                $response = array(
                    'status' => 'success',
                    'message' => 'specialisation deleted successfully.',
                    'redirect' => '../Admin/view-specialisations.php'
                );
                break;
            case 'not-existing':
                $response = array(
                    'status' => 'error',
                    'message' => 'specialisation not found.',
                    'redirect' => '../../Admin/view-specialisations.php'
                );
                break;
            case 'Failed':
                $response = array(
                    'status' => 'error',
                    'message' => 'An error occurred while deleting. Failed to delete the image.',
                    'redirect' => '../Admin/specialisation-details.php'
                );
                break;
            default:
                $response = array(
                    'status' => 'error',
                    'message' => 'An error occurred while deleting.',
                    'redirect' => '../Admin/specialisation-details.php'
                );
                break;
        }
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Invalid request. Missing specialisation id parameter.',
            'redirect' => '../Admin/view-specialisations.php'
        );
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Invalid request method.',
        'redirect' => '../Admin/view-specialisations.php'
    );
}

if (!headers_sent()) {
    echo json_encode($response);
}
?>
