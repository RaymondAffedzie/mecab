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

require_once '../controllers/storeController.php';
// Create an instance of the StoreController class
$controller = new StoreController();

$query = "SELECT * FROM `carousel` ORDER BY id DESC LIMIT 3";
$stmt = $db->prepare($query);
$stmt->execute();

$carouselData = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($carouselData);
