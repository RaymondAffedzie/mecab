<?php
session_start();
if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    header("Location: ../login.php");
	exit;
}

if ($_SESSION['role'] != 'Spare parts') {
	if ($_SESSION['role'] == 'Admin') {
		header("Location: ../Admin/index.php");
		exit;
	}
	if ($_SESSION['role'] == 'Mechanic') {
		header("Location: ../Mechanic/index.php");
		exit;
	}
	if ($_SESSION['role'] == 'Transport') {
		header("Location: ../Transport/index.php");
		exit;
	}
	if ($_SESSION['role'] == 'Car rentals') {
		header("Location: ../Car-rentals/index.php");
		exit;
	}
	if ($_SESSION['role'] == 'Customer') {
		header("Location: ../index.php");
		exit;
	}
}

if (!$_SESSION['isVerified']) {
    header("location: ../verification.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<title>MeCAB</title>
	<!-- plugins:css -->
	<link rel="stylesheet" href="../vendors/feather/feather.css" />
	<link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css" />
	<link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css" />
	<!-- endinject -->
	<!-- Plugin css for this page -->
	<link rel="stylesheet" href="../vendors/mdi/css/materialdesignicons.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
	<!-- End plugin css for this page -->
	<!-- inject:css -->
	<link rel="stylesheet" href="../css/vertical-layout-light/style.css" />
	<!-- customs style -->
	<link rel="stylesheet" href="../vendors/css/custom.css" />
	<!-- endinject -->
	<link rel="shortcut icon" href="../images/favicon.png" />
</head>