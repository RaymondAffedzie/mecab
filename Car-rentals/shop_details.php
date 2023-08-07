<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Prevent user from accessing this page when not logged in
if (!isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
	header("Location: ../login.php");
	exit;
}

// Prevent user from accessing this page when not verified
if (!$_SESSION['isVerified']) {
	// User's store is not verified
	header("location: ../verification.php");
	exit;
}

require_once '../controllers/storeController.php';
include_once('includes/head.php');
include_once('includes/navbar.php');

$controller = new storeController();
?>
<!-- partial -->
<div class="main-panel">
	<div class="content-wrapper">
		<div class="row">
			<div class="col-md-12 grid-margin">
				<div class="row">
					<?php
					$user = $controller->getUserDetails();
					$store = $controller->getUserStore($_SESSION['userId']);
					$usersCount = $controller->getStoreUsers($store['store_id']);
					$partCount = $controller->getStoreSpareParts($store['store_id']);
					?>
					<div class="col-12 col-xl-8 mb-4 mb-xl-0">
						<h3 class="font-weight-bold">
							Welcome to
							<?= '<span class="text-warning">' . $store['store_name'] . ' ' . $store['store_type'] . '</span> ' . $user['first_name'] . ' ' . $user['other_names'] . " " . $user['last_name']; ?>
						</h3>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-5 grid-margin transparent">
				<div class="row">
					<div class="col-md-6 mb-4 stretch-card transparent">
						<div class="card card-tale">
							<div class="card-body">
								<p class="mb-4">
									Users
								</p>
								<p class="font-weight-bold fs-30 mb-2">
									<?= count($usersCount); ?>
								</p>
							</div>
						</div>
					</div>
					<div class="col-md-6 mb-4 stretch-card transparent">
						<div class="card card-dark-blue">
							<div class="card-body">
								<p class="mb-4">
									Total Spare parts
								</p>
								<p class="font-weight-bold fs-30 mb-2">
									<?= count($partCount); ?>
								</p>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
						<div class="card card-light-blue">
							<div class="card-body">
								<p class="mb-4">
									Orders
								</p>
								<p class="fs-30 mb-2">34040</p>
							</div>
						</div>
					</div>
					<div class="col-md-6 stretch-card transparent">
						<div class="card card-light-danger">
							<div class="card-body">
								<p class="mb-4">
									Ratings
								</p>
								<p class="fs-30 mb-2">4.7</p>
								<p>47033 (Users)</p>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-7 grid-margin stretch-card">
				<div class="card text-left">
					<div class="card-body">
						<h1 class="card-title">Store Details</h1>
						<div class="d-flex flex-wrap mb-5">
							<!-- <div class="row"> -->
							<div class="col-md-6">
								<div class="mt-3">
									<p class="text-muted">Store Name</p>
									<h3 class="text-primary fs-20">
										<i class="ti-user mx-0"></i>
										<?= strtoupper($store['store_name']); ?>
									</h3>
								</div>
								<div class="mt-3">
									<p class="text-muted">Store Type</p>
									<h3 class="text-primary fs-20">
										<i class="mdi mdi-store"></i>
										<?= strtoupper($store['store_type']); ?>
									</h3>
								</div>
								<div class="mt-3">
									<p class="text-muted">Store Email</p>
									<h3 class="text-primary text-primary fs-20">
										<i class="mdi mdi-email-outline"></i>
										<?= strtolower($store['store_email']); ?>
									</h3>
								</div>
								<div class="mt-3">
									<p class="text-muted">
										Store Contact
									</p>
									<h3 class="text-primary text-primary fs-20">
										<i class="mdi mdi-phone-classic"></i>
										<?= $store['store_contact']; ?>
									</h3>
								</div>
							</div>
							<div class="col-md-6">
								<div class="mt-3">
									<p class="text-muted">GPS Address</p>
									<h3 class="text-primary fs-20">
										<i class="mdi mdi-map"></i>
										<?= strtoupper($store['gps_address']); ?>
									</h3>
								</div>
								<div class="mt-3">
									<p class="text-muted">
										Street Name
									</p>
									<h3 class="text-primary fs-20">
										<i class="mdi mdi-map-marker"></i>
										<?= strtoupper($store['street_name']); ?>
									</h3>
								</div>
								<div class="mt-3">
									<p class="text-muted">
										Store Town
									</p>
									<h3 class="text-primary text-primary fs-20">
										<i class="mdi mdi-map-marker-radius"></i>

										<?= $store['store_town']; ?>
									</h3>
								</div>
								<div class="mt-3">
									<p class="text-muted">
										Store Location
									</p>
									<h3 class="text-primary text-primary fs-20">
										<i class="mdi mdi-map-marker-circle"></i>
										<?= $store['store_location']; ?>
									</h3>
								</div>
							</div>
							<!-- </div> -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php
	include_once('includes/footer.php')
	?>