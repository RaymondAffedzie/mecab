<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// require_once 'controllers/storeController.php';
include_once('includes/head.php');
include_once('includes/navbar.php');

// $controller = new storeController();
?>
<!-- partial -->
<div class="main-panel">
	<div class="content-wrapper">
		<div class="row">
			<div class="col-md-12 grid-margin">
				<div class="row">

					<div class="col-12 col-xl-8 mb-4 mb-xl-0">
						<h3 class="font-weight-bold">
							MeCAB
						</h3>
						<span class="text-primary">
							Your Life Is Our Prominent Solidtude
						</span>
					</div>
					<!-- <div class="col-12 col-xl-4">
						<div class="justify-content-end d-flex">
							<div class="dropdown flex-md-grow-1 flex-xl-grow-0">
								<button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
									<i class="mdi mdi-calendar"></i>
									Today (10 Jan 2021)
								</button>
								<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
									<a class="dropdown-item" href="#">
										January - March
									</a>
									<a class="dropdown-item" href="#">
										March - June
									</a>
									<a class="dropdown-item" href="#">
										June - August
									</a>
									<a class="dropdown-item" href="#">
										August - November
									</a>
								</div>
							</div>
						</div>
					</div> -->
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 grid-margin stretch-card transparent">
				<div class="card text-center card-tale">
					<div class="card-body">
						<p class="card-title">System Under Development</p>
						<h1 class="text-light" id="countdown"></h1>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php
	include_once('includes/footer.php')
	?>