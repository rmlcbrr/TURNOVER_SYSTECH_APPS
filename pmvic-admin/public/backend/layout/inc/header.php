<?php

session_start();

if (!isset($_SESSION['userdata'])) {
	echo "<script> window.location.href = '../../';</script>";
}

$img_decode = $_SESSION['userdata']['pmvicImage'];

?>
<!DOCTYPE html>
<html>

<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8" />

	<!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="../../backend/vendors/images/favicon/apple-touch-icon.png" />
	<link rel="icon" type="image/png" sizes="32x32" href="../../backend/vendors/images/favicon/favicon-32x32.png" />
	<link rel="icon" type="image/png" sizes="16x16" href="../../backend/vendors/images/favicon/favicon-16x16.png" />

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="../../backend/vendors/styles/core.css" />
	<link rel="stylesheet" type="text/css" href="../../backend/vendors/styles/icon-font.min.css" />
	<link rel="stylesheet" type="text/css" href="../../backend/src/plugins/sweetalert2/sweetalert2.css" />
	<link rel="stylesheet" type="text/css" href="../../backend/src/plugins/datatables/css/dataTables.bootstrap4.min.css" />
	<link rel="stylesheet" type="text/css" href="../../backend/src/plugins/datatables/css/responsive.bootstrap4.min.css" />
	<link rel="stylesheet" type="text/css" href="../../backend/vendors/styles/style.css" />
</head>

	<!-- <div class="pre-loader">
			<div class="pre-loader-box">
				<div class="loader-logo">
					<img src="../../backend/img/logo.jpg" alt="" width=120/>
				</div>
				<div class="loader-progress" id="progress_div">
					<div class="bar" id="bar1"></div>
				</div>
				<div class="percent" id="percent1">0%</div>
				<div class="loading-text">Loading...</div>
			</div>
		</div> -->



<div class="header">
	<div class="header-left">
		<div class="menu-icon bi bi-list"></div>
		<div class="search-toggle-icon bi bi-search" data-toggle="header_search"></div>
		<!-- <div class="header-search">
					<form>
						<div class="form-group mb-0">
							<i class="dw dw-search2 search-icon"></i>
							<input
								type="text"
								class="form-control search-input"
								placeholder="Search Here"
							/>
							<div class="dropdown">
								<a
									class="dropdown-toggle no-arrow"
									href="#"
									role="button"
									data-toggle="dropdown"
								>
									<i class="ion-arrow-down-c"></i>
								</a>
								<div class="dropdown-menu dropdown-menu-right">
									<div class="form-group row">
										<label class="col-sm-12 col-md-2 col-form-label"
											>From</label
										>
										<div class="col-sm-12 col-md-10">
											<input
												class="form-control form-control-sm form-control-line"
												type="text"
											/>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-12 col-md-2 col-form-label">To</label>
										<div class="col-sm-12 col-md-10">
											<input
												class="form-control form-control-sm form-control-line"
												type="text"
											/>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-12 col-md-2 col-form-label"
											>Subject</label
										>
										<div class="col-sm-12 col-md-10">
											<input
												class="form-control form-control-sm form-control-line"
												type="text"
											/>
										</div>
									</div>
									<div class="text-right">
										<button class="btn btn-primary">Search</button>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div> -->
	</div>
	<div class="header-right">
		<div class="dashboard-setting user-notification">
			<div class="dropdown">
				<a class="dropdown-toggle no-arrow" href="javascript:;" data-toggle="right-sidebar">
					<i class="dw dw-settings2"></i>
				</a>
			</div>
		</div>
		<!-- <div class="user-notification">
					<div class="dropdown">
						<a
							class="dropdown-toggle no-arrow"
							href="#"
							role="button"
							data-toggle="dropdown"
						>
							<i class="icon-copy dw dw-notification"></i>
							<span class="badge notification-active"></span>
						</a>
						<div class="dropdown-menu dropdown-menu-right">
							<div class="notification-list mx-h-350 customscroll">
								<ul>
									<li>
										<a href="#">
											<img src="../../backend/vendors/images/img.jpg" alt="" />
											<h3>John Doe</h3>
											<p>
												Lorem ipsum dolor sit amet, consectetur adipisicing
												elit, sed...
											</p>
										</a>
									</li>
									<li>
										<a href="#">
											<img src="../../backend/vendors/images/photo1.jpg" alt="" />
											<h3>Lea R. Frith</h3>
											<p>
												Lorem ipsum dolor sit amet, consectetur adipisicing
												elit, sed...
											</p>
										</a>
									</li>
									<li>
										<a href="#">
											<img src="../../backend/vendors/images/photo2.jpg" alt="" />
											<h3>Erik L. Richards</h3>
											<p>
												Lorem ipsum dolor sit amet, consectetur adipisicing
												elit, sed...
											</p>
										</a>
									</li>
									<li>
										<a href="#">
											<img src="../../backend/vendors/images/photo3.jpg" alt="" />
											<h3>John Doe</h3>
											<p>
												Lorem ipsum dolor sit amet, consectetur adipisicing
												elit, sed...
											</p>
										</a>
									</li>
									<li>
										<a href="#">
											<img src="../../backend/vendors/images/photo4.jpg" alt="" />
											<h3>Renee I. Hansen</h3>
											<p>
												Lorem ipsum dolor sit amet, consectetur adipisicing
												elit, sed...
											</p>
										</a>
									</li>
									<li>
										<a href="#">
											<img src="../../backend/vendors/images/img.jpg" alt="" />
											<h3>Vicki M. Coleman</h3>
											<p>
												
											</p>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div> -->
		<div class="user-info-dropdown">
			<div class="dropdown">
				<a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
					<span class="user-icon">
						<img src="data:image/png;base64,<?= $img_decode ?>" alt="" />
					</span>
					<span class="user-name"><?= $_SESSION['userdata']['pmvicName'] ?></span>
				</a>
				<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
					<!-- <a class="dropdown-item" href="profile.html"
								><i class="dw dw-user1"></i> Profile</a
							>
							<a class="dropdown-item" href="settings.php"
								><i class="dw dw-settings2"></i> Setting</a
							>
							<a class="dropdown-item" href="faq.html"
								><i class="dw dw-help"></i> Help</a
							> -->
					<a class="dropdown-item" id="logout"><i class="dw dw-logout"></i> LOGOUT</a>
				</div>
			</div>
		</div>
	</div>
</div>