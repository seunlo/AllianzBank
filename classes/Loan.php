<?php
require_once "Db.php";
require_once "Transaction.php";




class Loan extends Db
{
  public function fetch_all_loan_type()
  {
    $sql = "SELECT * FROM loan_type";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute();
    $loan_type = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $loan_type;
  }
  public function fetch_all_repayment_period()
  {
    $sql = "SELECT * FROM loan_repayment_period";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute();
    $repayment_period = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $repayment_period;
  }

  public function create_loan($loan_type_id, $cust_id, $amount, $amount_due, $due_date)
  {
    $sql = "INSERT INTO loan_amount (loan_type_id, cust_id, amount, amount_due, due_date) VALUES (?, ?, ?, ?, ?)";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(1, $loan_type_id, PDO::PARAM_INT);
    $stmt->bindParam(2, $cust_id, PDO::PARAM_INT);
    $stmt->bindParam(3, $amount, PDO::PARAM_STR);
    $stmt->bindParam(4, $amount_due, PDO::PARAM_STR);
    $stmt->bindParam(5, $due_date, PDO::PARAM_STR);
    $stmt->execute();
    $rowCount = $stmt->rowCount();


    if ($rowCount > 0) {
      $loan_amt_id = $this->conn->lastInsertId();

      $_SESSION["loan_amt_id"] = $loan_amt_id;

      $sql = "SELECT loan_name FROM loan_type WHERE loan_type_id = ?";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(1, $loan_type_id, PDO::PARAM_INT);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $description = $row['loan_name'];





      $sql = "SELECT wallet_no FROM wallet WHERE cust_id = ?";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(1, $cust_id, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      $account_no = $result["wallet_no"];

      // $update_amount = $result['amount'] + $amount;
      // $sql = "UPDATE wallet SET amount = ? WHERE cust_id = ?";
      // $stmt = $this->connect()->prepare($sql);
      // $stmt->bindParam(1, $update_amount, PDO::PARAM_INT);
      // $stmt->bindParam(2, $cust_id, PDO::PARAM_INT);
      // $stmt->execute();

      $trans_type_id = 1;
      $trans = new Transaction();
      $trans->transfer($cust_id, $amount, $trans_type_id, $description, $account_no);

    }
  }




  public function check_status($loan_amt_id, $loan_type_id, $cust_id, $amount, $amount_due, $due_date)
  {
    $sql = "SELECT amount_due FROM loan_amount WHERE loan_amt_id = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(1, $loan_amt_id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // $row["amount_due"];

    $sql = "SELECT SUM(amount) as amount FROM loan_repayment WHERE loan_amt_id = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(1, $loan_amt_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);



    if ($result['amount'] >= $row["amount_due"]) {

      $this->create_loan($loan_type_id, $cust_id, $amount, $amount_due, $due_date);

    } else {
      echo "<script>alert('You still have existing Loan Balance')</script>";

    }
  }
  public function loan_repayment($loan_amt_id, $cust_id, $amount)
  {
    $sql = "INSERT into loan_repayment(loan_amt_id, cust_id, amount) VALUES(?, ?, ?)";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(1, $loan_amt_id, PDO::PARAM_INT);
    $stmt->bindParam(2, $cust_id, PDO::PARAM_INT);
    $stmt->bindParam(3, $amount, PDO::PARAM_INT);
    $stmt->execute();



    $sql = "SELECT loan_type_id FROM loan_amount WHERE loan_amt_id  = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(1, $loan_amt_id, PDO::PARAM_INT);
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    $loan_type_id = $res['loan_type_id'];

   


    $sql = "SELECT loan_name FROM loan_type WHERE loan_type_id = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(1, $loan_type_id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $description = $row['loan_name'];




    $sql = "SELECT wallet_no FROM wallet WHERE cust_id = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(1, $cust_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $account_no = $result["wallet_no"];




    $trans_type_id = 2;
    $trans = new Transaction();
    $trans->transfer($cust_id, $amount, $trans_type_id, $description, $account_no);
  }

  public function get_all_loan()
  {
    $sql = "SELECT * FROM loan_amount";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;

  }

}

$loan = new Loan();
$all = $loan->get_all_loan();
// echo "<pre>";
// print_r($all);
?>