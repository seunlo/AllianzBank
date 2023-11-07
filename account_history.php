<?php
include("partials/header.php");
require_once "classes/Transaction.php";
require_once "classes/Loan.php";
$details = new Transaction();
$get_all = $details->get_transaction_details($cust_id);
$opb = $details->get_opening_balance($cust_id);
$all_debit = $details->get_total_debit($cust_id);
$all_credit = $details->get_total_credit($cust_id);
// echo "<pre>";
//print_r($get_all);
//die();

$loan = new Loan();
$all = $loan->get_all_loan();
// echo "<pre>";
// print_r($all);
?>


<div class="row">
  <div class="col-md-8 m-auto">
    <div class="card w-75 m-auto">
      <table class="table table-striped table-success">
        <thead>
          <th>Account Name</th>
          <th>Account No</th>
          <th>Account Type</th>
          <th>Account Created</th>
        </thead>
        <tr>
          <td>
            <?php echo $all_customer['full_name']; ?>
          </td>
          <td>
            <?php echo $all_customer['wallet_no'] ?>
          </td>
          <td>
            <?php echo $all_customer['account type']; ?>
          </td>
          <td>
            <?php echo $all_customer['register_date']; ?>
          </td>
        </tr>
        <thead>
          <th>Opening Bal</th>
          <th>Total Debit</th>
          <th>Total Credit</th>
          <th>Closing Bal</th>
        </thead>
        <tr>
          <td>
            <?php echo number_format($opb['Opening_Balance'], 2); ?>
          </td>
          <td>
            <?php echo number_format($all_debit['Total_Debit'], 2); ?>
          </td>
          <td>
            <?php echo number_format($all_credit['Total_Credit'], 2); ?>
          </td>
          <td>
            <?php echo number_format($all_customer['amount'], 2); ?>
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-8 m-auto">
    <div class="card w-75 m-auto">
      <table class="table display" id="transaction">
        <thead>
          <th>S/N</th>
          <th>Date</th>
          <th>Description</th>
          <th>Credit</th>
          <th>Debit</th>
          <th>Balance</th>
        </thead>
        <?php $sn = 1;
        $credit = '0.00';
        $debit = '0.00';
        $current_total = 0;
        ?>
        <?php foreach ($get_all as $key) { 
          ?>
          <tr>
            <td>
              <?php echo $sn++; ?>
            </td>
            <td>
              <?php echo $key['date']; ?>
            </td>
            <td>
              <?php echo $key['description']; ?>
            </td>

            <?php if ($key['trans_type_id'] == 1) { ?>
              <td>
                <?php echo number_format($key['amount'], 2); ?>
              </td>
              <td>
                <?php echo $debit; ?>
              </td>
              <td>
                <?php echo number_format($current_total += $key['amount'], 2); ?>
              </td>
            <?php } elseif ($key['trans_type_id'] == 2) { ?>
              <td>
                <?php echo $credit; ?>
              </td>
              <td>
                <?php echo number_format($key['amount'], 2); ?>
              </td>

              <td>
                <?php echo number_format($current_total -= $key['amount'], 2); ?>
              </td>
            <?php } ?>
          </tr>
        <?php } ?>
      </table>
    </div>
  </div>
</div>

<?php
include_once "partials/footer.php";
?>