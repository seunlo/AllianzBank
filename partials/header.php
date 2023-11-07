<?php
session_start();
require "./classes/Customer.php";
if (isset($_SESSION["cust_id"])) {
  $cust_id = $_SESSION["cust_id"];
  $customer = new Customer();
  $all_customer = $customer->retrieveCustomer($cust_id);
  // echo "<pre>";
  // print_r($all_customer);
}

if (isset($_SESSION["loan_amt_id"])) {
  $loan_amt_id = $_SESSION["loan_amt_id"];
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="bootstrap/css/jquery.dataTables.min.css">
  <title>Document</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand text-light fw-bold" href="index.php">Allianz Bank</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active text-light" aria-current="page" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" href="accounts.php">Accounts</a>
          </li>
          <!--here, customer will not have access to the following link until they update profile-->
          <?php if (!empty($all_customer['utility_bill']) and !empty($all_customer['passport_photo']) and !empty($all_customer['valid_id'])) {
            ?>
            <li class="nav-item">
              <a class="nav-link text-light" href="statements.php">Account Statements</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-light" href="transfer.php">Funds Transfer</a>
            </li>
          <?php } ?>
          <li class="nav-item" style="margin-left:500px">
            <a class="nav-link text-light"><b>Account Balance:</b> N
              <?php echo $all_customer['amount']; ?>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" href="signout.php">LogOut</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>