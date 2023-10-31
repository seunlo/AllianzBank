<?php
include_once "Db.php";

class Transaction extends Db
{

  public function transfer($cust_id, $amount, $trans_type)
  {

    $deposit = 0;
    $sql = "SELECT amount FROM wallet WHERE cust_id = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(1, $cust_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['amount'] > $amount or $trans_type == 1) {
      $sql = "INSERT INTO transaction(cust_id, amount, trans_type) VALUES(?, ?, ?)";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(1, $cust_id, PDO::PARAM_INT);
      $stmt->bindParam(2, $amount, PDO::PARAM_STR);
      $stmt->bindParam(3, $trans_type, PDO::PARAM_STR);
      $stmt->execute();

      if ($stmt->rowCount() > 0) {

        if ($trans_type == 1) {
          echo "i got in";
          $result['amount'] = $result['amount'] + $amount;

          $current_ammount = $result['amount'];


          $sql = "UPDATE wallet SET amount = ? WHERE cust_id = ?";
          $stmt = $this->connect()->prepare($sql);
          $stmt->bindParam(1, $current_ammount, PDO::PARAM_INT);
          $stmt->bindParam(2, $cust_id, PDO::PARAM_INT);
          $stmt->execute();

        } elseif ($trans_type == 2) {

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
}

$trans = new Transaction();

$trans->transfer(13, 5000, 2);


?>