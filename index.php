<?php

include "partials/header.php";
//require_once "classes/Customer.php";



$isEmptyFound = false;

foreach ($all_customer as $key) {
  // echo "<pre>";
  // print_r($all_customer);
  // exit();
  if ($key === "") {
    $isEmptyFound = true;
    break;
  }
}
?>

<div class="container-fluid bg-success">
  <div class="row">
    <div class="col-md-11 m-auto">
      <div class="row">
        <div class="col-md-6">
          <div class="card w-100 h-100">
            <div class="card-body">
              <h3 class="text-danger fw-bolder">Welcome to ALLIANZBANK
                <?php echo $all_customer['full_name']; ?>!
              </h3>
              <p class="text-primary fw-bold">AllianzBank or any of its staff will never ask you for your account login
                details for any reason. Please disregard any message asking you for any sensitive information regarding
                your
                account with us. Feel free to call our 24hrs customer representatives in case you have any issue
                regarding
                your account. </p>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="row">

            <div class="col-md-6">
              <div class="card shadowBlack ">
                <img class="card-img-top" src="<?php echo $all_customer['passport_photo']; ?>" alt="Card image cap"
                  style="max-height: 155px;min-height: 155px">
                <div class="card-body">
                  <?php
                  if ($isEmptyFound === false) { ?>
                    <p> Profile has been updated Kindle Contat Us for any other information you want to add </p>
                  <?php } else { ?>
                    <a href="update.php" class="btn btn-outline-primary btn-block w-100">Update Profile</a>


                  <?php } ?>
                </div>
              </div>
            </div>


            <div class="col-md-6">
              <div class="card h-100">
                <img class="card-img-top" src="images/password.jpg" alt="Card image cap"
                  style="max-height: 155px;min-height: 155px">
                <div class="card-body">
                  <a href="changepassword.php" class="btn btn-outline-success btn-block w-100">Change Password</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-5">
        <div class="col-md-4">
          <div class="card">
            <img class="card-img-top" src="images/acount.jpg" style="max-height: 155px;min-height: 155px"
              alt="Card image cap">
            <div class="card-body">
              <a href="accounts.php" class="btn btn-outline-success btn-block w-100">Account Details</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card shadowBlack ">
            <img class="card-img-top" src="images/contacts.gif" alt="Card image cap"
              style="max-height: 155px;min-height: 155px">
            <div class="card-body">
              <a href="feedback.php" class="btn btn-outline-success btn-block w-100">Contact Us</a>
            </div>
          </div>
        </div>
        <?php if (!empty($all_customer['utility_bill']) and !empty($all_customer['passport_photo']) and !empty($all_customer['valid_id'])) { ?>
          <div class="col-md-4">
            <div class="card">
              <img class="card-img-top" src="images/transfer.jpg" alt="Card image cap"
                style="max-height: 155px;min-height: 155px">
              <div class="card-body">
                <a href="transfer.php" class="btn btn-outline-success btn-block w-100">Transfer Money</a>
              </div>
            </div>
          </div>
          <div class="col-md-4 my-4">
            <div class="card shadowBlack ">
              <img class="card-img-top" src="images/list.jpg" style="max-height: 155px;min-height: 155px"
                alt="Card image cap">
              <div class="card-body">
                <a href="account_history.php" class="btn btn-outline-success btn-block w-100">Transaction History </a>
              </div>
            </div>
          </div>
          <div class="col-md-4 my-4">
            <div class="card">
              <img class="card-img-top" src="images/loan.jpg" alt="Card image cap"
                style="max-height: 155px;min-height: 155px">
              <div class="card-body">
                <a href="loan.php" class="btn btn-outline-success btn-block w-100">Get a Loan</a>
              </div>
            </div>
          </div>
          <div class="col-md-4 my-4">
            <div class="card">
              <img class="card-img-top" src="images/investment2.jpg" alt="Card image cap"
                style="max-height: 155px;min-height: 155px">
              <div class="card-body">
                <a href="invest.php" class="btn btn-outline-success btn-block w-100">Invest Money</a>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<?php include "partials/footer.php"; ?>