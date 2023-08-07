<body>
	<div class="container-scroller">
		<!-- partial:partials/_navbar.html -->
		<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
			<div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
				<a class="navbar-brand brand-logo mr-5" href="./index.php">
					MeCAB
					<i class="mdi mdi-car text-primary" style="font-size: 30px"></i>
				</a>
				<a class="navbar-brand brand-logo-mini" href="./index.php">
					<i class="mdi mdi-car text-primary" style="font-size: 36px"></i>
				</a>
			</div>
			<div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
				<ul class="navbar-nav navbar-nav-right">
					<li class="nav-item nav-profile dropdown">
						<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
							<i class="ti-user mx-0 text-primary" style="font-size: 24px; "></i>
						</a>
						<div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
							<?php
							if (isset($_SESSION['loggedIn'])) {
							?>
								<form id="logoutForm" action="./logic/logout.php" method="post">
									<button type="submit" name="logout" class="btn btn-danger dropdown-item">
										<i class="ti-power-off text-primary"></i> Logout
									</button>
								</form>
							<?php
							} else {
							?>
								<a class="dropdown-item" href="./login.php">
									<i class="mdi mdi-login text-primary"></i> Login
								</a>
								<a class="dropdown-item" href="./register-store.php">
									<i class="mdi mdi-store text-primary"></i> Purchase Store
								</a>
								<a class="dropdown-item" href="./register-user.php">
									<i class="mdi mdi-account text-primary"></i> Create Account
								</a>
							<?php
							}
							?>
						</div>
					</li>
					<li class="nav-item nav-settings d-none d-lg-flex">
						<a class="nav-link" href="#">
							<i class="icon-ellipsis"></i>
						</a>
					</li>
				</ul>
				<button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
					<span class="icon-menu"></span>
				</button>
			</div>
		</nav>
		<!-- partial -->
		<div class="container-fluid page-body-wrapper">
			<!-- partial:partials/_settings-panel.html -->
			<div class="theme-setting-wrapper">
				<div id="settings-trigger"><i class="ti-settings"></i></div>
				<div id="theme-settings" class="settings-panel">
					<i class="settings-close ti-close"></i>
					<p class="settings-heading">SIDEBAR SKINS</p>
					<div class="sidebar-bg-options selected" id="sidebar-light-theme">
						<div class="img-ss rounded-circle bg-light border mr-3"></div>
						Light
					</div>
					<div class="sidebar-bg-options" id="sidebar-dark-theme">
						<div class="img-ss rounded-circle bg-dark border mr-3"></div>
						Dark
					</div>
					<p class="settings-heading mt-2">HEADER SKINS</p>
					<div class="color-tiles mx-0 px-4">
						<div class="tiles success"></div>
						<div class="tiles warning"></div>
						<div class="tiles danger"></div>
						<div class="tiles info"></div>
						<div class="tiles dark"></div>
						<div class="tiles default"></div>
					</div>
				</div>
			</div>
			<div id="right-sidebar" class="settings-panel">
				<i class="settings-close ti-close"></i>
				<ul class="nav nav-tabs border-top" id="setting-panel" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="todo-tab" data-toggle="tab" href="#todo-section" role="tab" aria-controls="todo-section" aria-expanded="true">
							TO DO LIST
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="chats-tab" data-toggle="tab" href="#chats-section" role="tab" aria-controls="chats-section">
							CHATS
						</a>
					</li>
				</ul>
				<div class="tab-content" id="setting-content">
					<div class="tab-pane fade show active scroll-wrapper" id="todo-section" role="tabpanel" aria-labelledby="todo-section">
						<div class="add-items d-flex px-3 mb-0">
							<form class="form w-100">
								<div class="form-group d-flex">
									<input type="text" class="form-control todo-list-input" placeholder="Add To-do" />
									<button type="submit" class="add btn btn-primary todo-list-add-btn" id="add-task">
										Add
									</button>
								</div>
							</form>
						</div>
						<div class="list-wrapper px-3">
							<ul class="d-flex flex-column-reverse todo-list">
								<li>
									<div class="form-check">
										<label class="form-check-label">
											<input class="checkbox" type="checkbox" />
											Team review meeting at 3.00 PM
										</label>
									</div>
									<i class="remove ti-close"></i>
								</li>
							</ul>
						</div>
						<h4 class="px-3 text-muted mt-5 font-weight-light mb-0">
							Events
						</h4>
						<div class="events pt-4 px-3">
							<div class="wrapper d-flex mb-2">
								<i class="ti-control-record text-primary mr-2"></i>
								<span>Feb 11 2018</span>
							</div>
							<p class="mb-0 font-weight-thin text-gray">
								Creating component page build a js
							</p>
							<p class="text-gray mb-0">
								The total number of sessions
							</p>
						</div>
					</div>
					<!-- To do section tab ends -->
					<div class="tab-pane fade" id="chats-section" role="tabpanel" aria-labelledby="chats-section">
						<div class="d-flex align-items-center justify-content-between border-bottom">
							<p class="settings-heading border-top-0 mb-3 pl-3 pt-0 border-bottom-0 pb-0">
								Friends
							</p>
							<small class="settings-heading border-top-0 mb-3 pt-0 border-bottom-0 pb-0 pr-3 font-weight-normal">
								See All
							</small>
						</div>
						<ul class="chat-list">
							<li class="list active">
								<div class="profile">
									<img src="images/faces/face1.jpg" alt="image" />
									<span class="online"></span>
								</div>
								<div class="info">
									<p>Thomas Douglas</p>
									<p>Available</p>
								</div>
								<small class="text-muted my-auto">
									19 min
								</small>
							</li>
						</ul>
					</div>
					<!-- chat tab ends -->
				</div>
			</div>
			<!-- partial -->
			<!-- partial:partials/_sidebar.html -->
			<nav class="sidebar sidebar-offcanvas" id="sidebar">
				<ul class="nav">
					<li class="nav-item">
						<a class="nav-link" href="./index.php">
							<i class="icon-grid menu-icon"></i>
							<span class="menu-title">Home</span>
						</a>
					</li>
				</ul>
			</nav>