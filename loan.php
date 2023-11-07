<?php
include("partials/header.php");
require_once "classes/Loan.php";
$loan = new Loan();
$all_loan = $loan->fetch_all_loan_type();
$repayment_period = $loan->fetch_all_repayment_period();

if (isset($_POST['submt_btn'])) {
  $loan_type_id = $_POST['loan_type'];
  $amount = $_POST['amount'];
  $amount_due = $_POST['amount_due'];
  $due_date = $_POST['futureDate'];
  $loan->check_status($loan_amt_id, $loan_type_id, $cust_id, $amount, $amount_due, $due_date);
}

if (isset($_POST['loan_pay_btn'])) {
  $amount = $_POST['loan_pay'];

  $loan->loan_repayment($loan_amt_id, $cust_id, $amount);
}
?>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-7">
      <h1>Unlock the power of finance</h1>
      <h5>Apply for loan at affordable rate</h5>
    </div>
  </div>
  <div class="row bg-dark text-light">
    <div class="col-md-4 my-5">
      <h5>Convenient loans</h5>
    </div>
    <div class="col-md-4 my-5">
      <h5>NDIC Insured Savings and Deposit</h5>
    </div>
    <div class="col-md-4 my-5">
      <h5>CBN regulated</h5>
    </div>
  </div>
  <div class="row">
    <form method="post">
      <input type="number" name="amount" id="amount" placeholder="Enter Amount" class="form-control">
      <select name="loan_type" class="form-select bg-dark text-light" id="fetchData">
        <option value="">Select Loan Type</option>
        <?php foreach ($all_loan as $key) { ?>
          <option value="<?php echo $key['loan_type_id']; ?>">
            <?php echo $key['loan_name']; ?>
          </option>
        <?php } ?>
      </select>
      <select name="repayment_period" class="form-select bg-dark text-light" id="durationSelect">
        <option value="">Select Repayment Period</option>
        <?php foreach ($repayment_period as $key) { ?>
          <option value="<?php echo $key['loan_repay_period_id']; ?>">
            <?php echo $key['period']; ?>
          </option>
        <?php } ?>
      </select>
      <input type="hidden" name="amount_due" id="amount_due">
      <input type="hidden" id="futureDateInput" name="futureDate">
      <input type="hidden" id="rate" name="rate">
      <input type="submit" class="form-control btn btn-outline-success" value="Submit" name="submt_btn">
    </form>
    <p id="dataDisplay"></p>
    <p id="result"></p>
  </div>

  <div class="row">
    <div class="col">
      <form method="post">
        <input type="number" class="form-control w-50" name="loan_pay">
        <input type="submit" value="Submit" class="btn btn-success" name="loan_pay_btn">
      </form>
    </div>
  </div>
</div>

<?php include "partials/footer.php"; ?>