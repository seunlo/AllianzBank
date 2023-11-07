<?php
include_once "Db.php";

class Transaction extends Db
{
  public function transfer($cust_id, $amount, $trans_type_id, $description, $account_no)
  {
    $sql = "SELECT amount FROM wallet WHERE cust_id = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(1, $cust_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['amount'] > $amount or $trans_type_id == 1) {
      $sql = "INSERT INTO transaction(cust_id, amount, trans_type_id, description, account_no) VALUES(?, ?, ?, ?, ?)";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(1, $cust_id, PDO::PARAM_INT);
      $stmt->bindParam(2, $amount, PDO::PARAM_STR);
      $stmt->bindParam(3, $trans_type_id, PDO::PARAM_INT);
      $stmt->bindParam(4, $description, PDO::PARAM_STR);
      $stmt->bindParam(5, $account_no, PDO::PARAM_STR);
      $stmt->execute();

      if ($stmt->rowCount() > 0) {

        if ($trans_type_id == 1) {
          //echo "i got in";
          $result['amount'] = $result['amount'] + $amount;

          $current_ammount = $result['amount'];

          $sql = "UPDATE wallet SET amount = ? WHERE cust_id = ?";
          $stmt = $this->connect()->prepare($sql);
          $stmt->bindParam(1, $current_ammount, PDO::PARAM_INT);
          $stmt->bindParam(2, $cust_id, PDO::PARAM_INT);
          $stmt->execute();

        } elseif ($trans_type_id == 2) {

          $result['amount'] = $result['amount'] - $amount;
          $sql = "UPDATE wallet SET amount = ? WHERE cust_id = ?";
          $stmt = $this->connect()->prepare($sql);
          $stmt->bindParam(1, $result['amount'], PDO::PARAM_INT);
          $stmt->bindParam(2, $cust_id, PDO::PARAM_INT);
          $stmt->execute();
        }
      }
    } else {
      echo "<script>alert('Your balance is not sufficient for this transaction')</script>";
      exit();
    }
  }
  public function get_transaction_type()
  {
    $sql = "SELECT * FROM transaction_type";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute();
    $transaction = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $transaction;
  }
  public function get_transaction_details($cust_id)
  {
    $sql = "SELECT
    transaction.date, transaction.amount, transaction.description, transaction.trans_type_id,
    transaction_type.trans_type_name
    FROM
    transaction
    JOIN transaction_type ON transaction_type.trans_type_id = transaction.trans_type_id
    WHERE transaction.cust_id = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(1, $cust_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;

  }
  public function get_opening_balance($cust_id)
  {
    $sql = "SELECT amount as Opening_Balance  FROM transaction where cust_id = ? limit 1";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(1, $cust_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
  }
  public function get_total_debit($cust_id)
  {
    $sql = "SELECT Sum(amount) as Total_Debit  FROM transaction where cust_id = ? and trans_type_id = 2";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(1, $cust_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
  }
  public function get_total_credit($cust_id)
  {
    $sql = "SELECT Sum(amount) as Total_Credit  FROM transaction where cust_id = ? and trans_type_id = 1";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(1, $cust_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
  }
}

$trans = new Transaction();
//echo $trans->transfer(13, 6500, 1, 'payment for children books');
// echo "<pre>";
// print_r($get_transaction);
?>