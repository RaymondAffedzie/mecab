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

if (isset($_GET['service'])) {
    $service =  filter_input(INPUT_GET, 'service', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $query = "SELECT  c.*, s.* FROM categories c 
              INNER JOIN spare_parts s ON c.service_id = s.service_id 
              WHERE s.service_id = :service ";

    $params = array(':service' => $service);
    $services = $controller->getRecordsByValue($query, $params);
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="h-100 p-5 text-bg-dark rounded-3">
                <h2>Change the background</h2>
                <p>Swap the background-color utility and add a `.text-*` color utility to mix up the jumbotron look. Then, mix and match with additional component themes and more.</p>
                <button class="btn btn-outline-light" type="button">Example button</button>
            </div>
        </div>
        
        
    </div>
</div>

<?php
include_once('includes/footer.php')
?>