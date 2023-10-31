<?php
session_start();
include_once "partials/headerlogin.php";
require_once "classes/Customer.php";
require_once "classes/Account.php";

$acctype = new Account();
$all_account = $acctype->fetch_all_account_type();

if ($_POST) {
	if (isset($_POST["reg_btn"])) {
		$full_name = $_POST["fullname"];
		$phone_number = $_POST["phone"];
		$password = $_POST["password"];
		$confirm_password = $_POST["cpassword"];
		$account = $_POST["account_type"];

	
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);
		$customer = new Customer();
		 $customer->customerReg($full_name, $phone_number, $hashed_password, $account);

		// if ($response) {
		// 	echo "<script>alert('Registered successfully')</script>";
		// }
	}




	if (isset($_POST["userLogin"])) {
		$phone_number = $_POST["cust_number"];
		$password = $_POST["cust_password"];


		$customer = new Customer();
		$customer->customerLog($phone_number, $password);


	}
}

//Does the session exist.
if (isset($_SESSION["error"])) {
	$msg = $_SESSION["error"];
} else {
	$msg = "";
}
?>

<div class="container-fluid bg-dark">
	<div class="row">
		<div class="col-md mt-5 text-light"></div>
	</div>
	<div class="row">
		<div class="col-md bg-info">
			<h3 class="text-danger fw-bold py-3">Allianz Bank</h3>
		</div>
		<div class="row">
			<div class="col-md-8">
				<img src="images/loginphoto.jpg" style="height:500px; width:100%">
			</div>
			<div class="col-md-4 m-auto">
				<div class="card bg-dark">
					<div class="card-body">
						<h2 class="text-center text-light">Select Your Session</h2>
					</div>
				</div>
				<div class="accordion" id="accordionExample">
					<div class="accordion-item">
						<h2 class="accordion-header" id="headingOne">
							<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
								aria-expanded="true" aria-controls="collapseOne">
								User Login
							</button>
						</h2>
						<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
							data-bs-parent="#accordionExample">
							<div class="accordion-body">
								<!----------------------------USER-LOGIN----------------------------------->
								<?php if (!empty($msg)) {
									?>
								<div>
									<?php echo $msg; ?>
								</div>
								<?php unset($_SESSION['error']); ?>
								<?php } ?>
								<form method="POST">
									<input type="number" name="cust_number" class="form-control" required
										placeholder="Enter Phone Number">
									<input type="password" name="cust_password" class="form-control" required
										placeholder="Enter Password">
									<button type="submit" class="w-100 btn btn-primary btn-block btn-lg my-1" name="userLogin">Enter
									</button>
								</form>
							</div>
						</div>
					</div>

					<div class="accordion-item">
						<h2 class="accordion-header" id="headingThree">
							<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
								data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
								Admin Login
							</button>
						</h2>
						<div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
							data-bs-parent="#accordionExample">
							<div class="accordion-body">
								<form method="POST">
									<input type="number" name="pnumber" class="form-control" required placeholder="Enter Phone Number">
									<input type="password" name="password" class="form-control" required placeholder="Enter Password">
									<button type="submit" class="w-100 btn btn-primary btn-block btn-lg my-1" name="userLogin">Enter
									</button>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 my-3">
						<button type="button" class="text-danger btn btn-info mt-3 fw-bold w-100" data-bs-toggle="modal"
							data-bs-target="#mywork">Click Here to Register</button>
						<div class="modal" tabindex="-1" id="mywork">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header bg-info">
										<h5 class="modal-title">Fill form below to register</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
									<div class="modal-body">
										<!-----------------------------REGISTRATION AREA------------------------------------------>
										<form method="post">
											<input type="text" name="fullname" placeholder="Enter full name" class="form-control">
											<input type="number" name="phone" placeholder="Enter Phone Number" class="form-control my-3">
											<input type="password" name="password" placeholder="Enter Password" class="form-control">
											<input type="password" name="cpassword" placeholder="Enter Confirm Password"
												class="form-control my-3">
											<select name="account_type" id="" class="mb-3 form-select bg-secondary text-light">
												<option value="">Select Category</option>
												<?php foreach ($all_account as $key) { ?>
													<option value="<?php echo $key['acct_id']; ?>">
														<?php echo $key['type']; ?>
													</option>
												<?php } ?>
											</select>
											<input type="submit" value="Submit" name="reg_btn" class="w-100 btn btn-danger">
										</form>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include "partials/footer.php"; ?>