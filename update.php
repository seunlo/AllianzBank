<?php
session_start();
include("partials/header.php");
require_once("classes/Customer.php");

if (isset($_SESSION["cust_id"])) {
  $cust_id = $_SESSION["cust_id"];
  $customer = new Customer();
  $all_customer = $customer->retrieveCustomer($cust_id);
  //print_r($all_customer);
}

if (isset($_POST["update_btn"])) {
  $full_name = $_POST['fullname'];
  $email_address = $_POST['mail'];
  $home_address = $_POST['homeaddress'];
  $phone_number = $_POST['phone'];
  $targetDirectory = "uploads/";
  $utility = $targetDirectory . basename($_FILES['utilitybill']['name']);
  $passport = $targetDirectory . basename($_FILES['passport']['name']);
  $valididen = $targetDirectory . basename($_FILES['valididen']['name']);

  move_uploaded_file($_FILES['passport']['tmp_name'], $passport);
  move_uploaded_file($_FILES['utilitybill']['tmp_name'], $utility);
  move_uploaded_file($_FILES['valididen']['tmp_name'], $valididen);

  $customer = new Customer();
  $customer->customer_update($full_name, $email_address, $home_address, $phone_number, $utility, $passport, $valididen, $cust_id);

}

?>

<div class="container-fluid">
  <div class="row">
    <div class="col-md">
      <form method="post" enctype="multipart/form-data">
        <label for="fullname">Full Name</label>
        <input type="text" name="fullname" class="form-control" value="<?php echo $all_customer['full_name']; ?>">
        <label for="mail">Email Address</label>
        <input type="email" name="mail" class="form-control">
        <label for="homeaddress">Home Address</label>
        <input type="text" name="homeaddress" class="form-control">
        <label for="phone">Phone Number</label>
        <input type="number" name="phone" class="form-control" value="<?php echo $all_customer['phone_number'] ?>">
        <label for="utilitybill">Utility Bill</label>
        <input type="file" name="utilitybill" class="form-control">
        <label for="passport">Passport Photo</label>
        <input type="file" name="passport" class="form-control">
        <label for="valididen">Valid Identification</label>
        <input type="file" name="valididen" class="form-control">
        <div>
          <input type="submit" class="btn btn-danger" value="Click here to submit" name="update_btn">
        </div>
      </form>

    </div>
  </div>
</div>