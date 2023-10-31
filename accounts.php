<?php
//session_start();
include "partials/header.php";
require_once "classes/Customer.php";
require_once "classes/RandomNumber.php";

if (isset($_SESSION["cust_id"])) {
  $cust_id = $_SESSION["cust_id"];
  $customer = new Customer();
  $all_customer = $customer->retrieveCustomer($cust_id);
  $getNumber = $customer->get_wallet_no($cust_id);
  //echo "<pre>";
  //print_r($getNumber);
}


if(isset($all_customer['wallet_no'])) {
  $acct_num = $all_customer['wallet_no'];
}else{
  $acct_num = null;
}
?>
<div class="container">
  <div class="row">
    <div class="col-md-8 mt-5 m-auto">
      <div class="card  w-100 mx-auto">
        <div class="card-header text-center">
          Your account Information
        </div>
        <div class="card-body">
          <table class="table table-striped table-dark w-75 mx-auto">
            <thead>
              <tr>
                <td>Account No.
                  <?php echo $acct_num; ?>
                </td>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th>Account Name</th>
                <td>
                  <?php echo $all_customer['full_name']; ?>
                </td>
              </tr>
              <tr>
                <th>Account Type</th>
                <td>
                  <?php echo $all_customer['account type']; ?>
                </td>
              </tr>
              <tr>
                <th>Account Created</th>
                <td>
                  <?php echo $all_customer['register_date']; ?>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>