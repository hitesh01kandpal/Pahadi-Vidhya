<?php
include "../includes/config.php";
if(!isset($_SESSION['user_id']) || !isset($_SESSION['type']) ){
    header("Location:../login.php");
}
$pageName = basename($_SERVER['PHP_SELF']);
$id = $_SESSION['user_id'];
$role = $_SESSION['type'];
if (isset($_POST["submit"])) {
	$name = $_POST['name'];
	$email = $_POST['email'];
	$street = $_POST['street'];
	$phone = $_POST['phone'];
	$dob = $_POST['dob'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$code = $_POST['zip'];
	$address = $street . '#' . $city . '#' . $state . '#' . $code;
	mysqli_query($conn, "UPDATE `$role` SET `name`='$name',`phone`='$phone',`DOB`='$dob',`email`='$email',`address`='$address' WHERE `id`='$id'");
	mysqli_query($conn, "UPDATE `login` SET `email`='$email' WHERE `reg_id`='$id'");
}
$res = mysqli_query($conn, "SELECT `id`, `name`, `dept_id`, `phone`, `DOB`, `email`, `address` FROM `$role` where `id`='$id'");
$row = mysqli_fetch_array($res);

if ($role == 'admin') {
	$dept_name = "Aministrative";
} else {
	$dept_id = $row['dept_id'];
	$dept_name = mysqli_query($conn, "SELECT `dept_name` FROM `department` WHERE `dept_id`='$dept_id'");
	$dept_name = mysqli_fetch_array($dept_name);
	$dept_name = $dept_name['dept_name'];
}
$address_arr = [];
if ($row['address'])
	$address_arr = explode("#", $row['address']);
?>
<html>

<head>
	<link rel="stylesheet" href="../CSS/admin.css">
	<link rel="stylesheet" href="../CSS/profile_css.css">
	<?php include '../includes/cdn.php'; ?>
	<link rel="stylesheet" href="../CSS/sidebar.css">
	<link rel="stylesheet" href="../CSS/footer.css">;

	<style>
		.outer {
			display: table;
			position: absolute;
			top: 0;
			left: 0;
			height: 100%;
			width: 100%;
		}

		.middle {
			display: table-cell;
			vertical-align: middle;
		}

		.inner {
			margin-left: auto;
			margin-right: auto;
			vertical-align: middle;
		}
	</style>
</head>

<body>

	<?php include '../includes/sidebar.php'; ?>
	<section class="home">
		<div class="outer">
			<div class="middle ">
				<div class="inner" style="min-height: calc(100vh - 132px); padding: 50px 0;">
					<form action="profile.php" method="POST">
						<div class="container">
							<div class="row gutters">
								<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
									<div class="card h-100">
										<div class="card-body mt-5">
											<div class="account-settings">
												<div class="user-profile">
													<div class="user-avatar">
														<img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Maxwell Admin">
													</div>
													<h5 class="user-name"><?php echo $row['name']; ?></h5>
													<h6 class="user-email"><?php echo $row['email']; ?></h6>
													<button type="button" class="btn btn-link mt-2" onclick="editProfile()">Edit Profile</button>
													<br/>
													<a href="../Password/change_password.php">Change password</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
									<div class="card h-100">
										<div class="card-body">
											<div class="row gutters">
												<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
													<h6 class="mb-2 text-primary">Personal Details</h6>
												</div>
												<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
													<div class="form-group">
														<label for="fullName">Full Name</label>
														<input type="text" class="form-control" name="name" placeholder="Enter full name" value="<?php echo $row['name'] ?>" disabled>
													</div>
												</div>
												<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
													<div class="form-group">
														<label for="eMail">Email</label>
														<input type="email" class="form-control" name="email" placeholder="Enter email ID" value="<?php echo $row['email'] ?>" disabled>
													</div>
												</div>
												<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
													<div class="form-group">
														<label for="phone">Phone</label>
														<input type="text" maxlength="10" minlength="10" class="form-control" name="phone" placeholder="Enter phone number" value="<?php echo $row['phone'] ?>" disabled>
													</div>
												</div>
												<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
													<div class="form-group">
														<label for="DOB">DOB</label>
														<input type="text" class="form-control" name="dob" value="<?php echo $row['DOB'] ?>" disabled>
													</div>
												</div>
											</div>
											<div class="row gutters">
												<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
													<h6 class="mt-3 mb-2 text-primary">Address</h6>
												</div>
												<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
													<div class="form-group">
														<label for="Street">Street</label>
														<input type="name" class="form-control" name="street" placeholder="Enter Street" value="<?php if ($row['address']) echo $address_arr[0] ?>" disabled>
													</div>
												</div>
												<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
													<div class="form-group">
														<label for="ciTy">City</label>
														<input type="name" class="form-control" name="city" placeholder="Enter City" value="<?php if ($row['address']) echo $address_arr[1] ?>" disabled>
													</div>
												</div>
												<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
													<div class="form-group">
														<label for="sTate">State</label>
														<input type="text" class="form-control" name="state" placeholder="Enter State" value="<?php if ($row['address']) echo $address_arr[2] ?>" disabled>
													</div>
												</div>
												<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
													<div class="form-group">
														<label for="zIp">Zip Code</label>
														<input type="text" class="form-control" name="zip" placeholder="Zip Code" value="<?php if ($row['address']) echo $address_arr[3] ?>" disabled>
													</div>
												</div>
											</div>
											<div class="row gutters">
												<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
													<h6 class="mt-3 mb-2 text-primary">College</h6>
												</div>
												<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
													<div class="form-group">
														<label for="registration">Registration Number</label>
														<input type="name" class="form-control" id="Street" placeholder="Enter Registration" value="<?php echo $row['id'] ?>" disabled>
													</div>
												</div>
												<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
													<div class="form-group">
														<label for="dept">Depratment</label>
														<input type="name" class="form-control" id="dept" placeholder="Enter Depratment" value="<?php echo $dept_name; ?>" disabled>
													</div>
												</div>
											</div>
											<div class="row gutters">
												<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
													<div class="text-right mt-4" style="float:right">

														<button type="submit" name="submit" class="btn btn-warning" hidden>Update</button>
														<button type="button" class="btn btn-danger" onclick="cancleEdit()" hidden>Cancel</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
				<?php include '../includes/footer.php'; ?>
			</div>
		</div>
	</section>
	<script type="text/javascript" src="../js/sidebar.js"></script>
	<script>
		function editProfile() {
			let tmp = document.getElementsByTagName("input");
			tmp[0].disabled = false;
			tmp[1].disabled = false;
			tmp[2].disabled = false;
			tmp[3].disabled = false;
			tmp[4].disabled = false;
			tmp[5].disabled = false;
			tmp[6].disabled = false;
			tmp[7].disabled = false;
			let btn = document.getElementsByTagName("button");
			btn[1].hidden = false;
			btn[2].hidden = false;
		}

		function cancleEdit() {
			let tmp = document.getElementsByTagName("input");
			tmp[0].disabled = true;
			tmp[1].disabled = true;
			tmp[2].disabled = true;
			tmp[3].disabled = true;
			tmp[4].disabled = true;
			tmp[5].disabled = true;
			tmp[6].disabled = true;
			tmp[7].disabled = true;
			let btn = document.getElementsByTagName("button");
			btn[1].hidden = true;
			btn[2].hidden = true;
		}
	</script>
	<?php include '../includes/checkDarkTheme.php'; ?>
</body>

</html>