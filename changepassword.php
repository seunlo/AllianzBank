<?php
require_once("partials/header.php");
require_once "classes/Customer.php";
$cust_id = $_SESSION["cust_id"];
$customer = new Customer();

if (isset($_POST['change_pass_btn'])) {
  $oldpassword = $_POST['current_password'];
  $newpassword = $_POST['new_password'];
  $customer->change_password($cust_id, $newpassword, $oldpassword);
}






?>
<div class="container">

  <div class="row mt-3">
    <div class="col-md-9 mb-4 m-auto">
      <div class="card mb-4">
        <div class="card-body" style="min-height:200px">

          <form action="" method="post">
            <div class="mb-3">
              <label for="old_password" class="form-label">Old Password</label>
              <input type="password" name="current_password" class="form-control bg-secondary text-light">
            </div>
            <div class="mb-3">
              <label for="new_password" class="form-label">New Password</label>
              <input type="password" class="form-control bg-secondary text-light" name="new_password">
            </div>
            <button class="btn btn-success rounded-3 bg-success" name="change_pass_btn">Change Password</button>
          </form>

        </div>
      </div>
    </div>


  </div>
</div>