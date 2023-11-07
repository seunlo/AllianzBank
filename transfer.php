<?php
include_once "partials/header.php";
require_once "classes/Transaction.php";
$types = $trans->get_transaction_type();


if (isset($_POST["submit_btn"])) {
  $amount = $_POST["amount"];
  $account_no = $_POST["account_no"];
  $description = $_POST['description'];
  $trans_type_id = $_POST['trans_type'];

  if (empty($account_no)) {
    $account_no = $all_customer['wallet_no'];
  }

  $trans = new Transaction();
  $trans->transfer($cust_id, $amount, $trans_type_id, $description, $account_no);
}
?>
<div class="container">
  <div class="row">
    <div class="col-md-7 m-auto">

      <form method="post">
        <input type="number" name="amount" placeholder="Enter Amount" class="form-control">
        <input type="text" name="description" placeholder="Description" class="form-control">
        <select name="trans_type" id="mySelect" class="form-select bg-success text-light">
          <option value="">Select Transaction Type</option>
          <?php foreach ($types as $key) { ?>
            <option value="<?php echo $key['trans_type_id']; ?>">
              <?php echo $key['trans_type_name']; ?>
            </option>
          <?php } ?>
        </select>
        <input type="number" id="account_no" name="account_no" placeholder="Enter Account No" class="form-control">
        <input type="submit" name="submit_btn" value="Click here to submit"
          class="form-control btn btn-outline-success">
      </form>
    </div>
  </div>
</div>
<?php
include_once 'partials/footer.php';
?>