<?php
include_once "Db.php";
include_once "RandomNumber.php";

class Customer extends Db
{

  public function customerReg($full_name, $phone_number, $password, $acct_id)
  {
    //check if email is in db before
    $sql = "SELECT * FROM customer WHERE phone_number = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(1, $phone_number, PDO::PARAM_STR);
    $stmt->execute();
    $cust_count = $stmt->rowCount();
    //if $cust_count is greater than zero it means the email already exist in the db
    if ($cust_count > 0) {
      echo "<script>alert('Phone-Number already Registered')</script>";
      exit();
    }


    //email does not exist to get to this line, so insert into db
    $sql = "INSERT INTO customer(full_name, phone_number, password,  acct_id) VALUES(?, ?, ?, ?)";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(1, $full_name, PDO::PARAM_STR);
    $stmt->bindParam(2, $phone_number, PDO::PARAM_STR);
    $stmt->bindParam(3, $password, PDO::PARAM_STR);
    $stmt->bindParam(4, $acct_id, PDO::PARAM_INT);
    $stmt->execute();

    $rowcount = $stmt->rowCount();

    if ($rowcount > 0) {
      $cust_id = $this->conn->lastInsertId();

      $number = new RandomNumber();
      $amount = 0;
      $acccunt_num = $number->generateNumber(10);
      $sql = "INSERT INTO wallet(cust_id, amount, wallet_no) VALUES(?, ?, ?)";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(1, $cust_id, PDO::PARAM_INT);
      $stmt->bindParam(2, $amount, PDO::PARAM_STR);
      $stmt->bindParam(3, $acccunt_num, PDO::PARAM_STR);
      $stmt->execute();

    }
  }
  public function get_wallet_no($cust_id)
  {
    $sql = "SELECT * FROM wallet WHERE cust_id = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(1, $cust_id, PDO::PARAM_INT);
    $stmt->execute();
    $number = $stmt->fetch(PDO::FETCH_ASSOC);
    return $number;

  }

  public function customerLog($phone_number, $password)
  {
    $sql = "SELECT * FROM customer WHERE phone_number = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(1, $phone_number, PDO::PARAM_STR);
    $stmt->execute();
    $cust_count = $stmt->rowCount();


    //if it is not in db then count will be less than one
    if ($cust_count < 1) {
      //if it is not in db: return error messag

      // create a session to display an error message.
      $_SESSION["error"] = "Either Phone Number or password is incorrect";
      header("location:./login.php");
      exit;
    }

    //if it is in db: we want the full detail of that user that owns the email
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);
    // echo "<pre>";
    // print_r($customer);
    //check if password matches using password_verify()
    $password_matches = password_verify($password, $customer['password']);
    //if it matches::set session
    if ($password_matches) {
      $_SESSION["cust_id"] = $customer["cust_id"];
      header("location:./index.php");
      exit();

    }
    //return error message
    return "Either Phone Number or password is incorrect";
  }

  public function change_password($cust_id, $new_password, $oldpassword)
  {
    $sql = "SELECT password FROM customer WHERE cust_id = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(1, $cust_id, PDO::PARAM_INT);
    $stmt->execute();
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);
    $password_matches = password_verify($oldpassword, $customer['password']);
    if ($password_matches) {
      $new_password = password_hash($new_password, PASSWORD_DEFAULT);
      $updateSql = "UPDATE customer SET  password = ?";
      $updateStmt = $this->connect()->prepare($updateSql);
      $updateStmt->bindParam(1, $new_password, PDO::PARAM_STR);
      $updateStmt->execute();
      $cust_count = $updateStmt->rowCount();

      if ($cust_count > 0) {
        echo "<script> alert('Password has been updated') </script>";
      } else {
        echo "<script> alert('An error has occcured') </script>";
      }
    } else {
      echo "<script> alert('Your Old Password is incorect') </script>";
    }

  }

  public function retrieveCustomer($cust_id)
  {
    $sql = "SELECT customer.cust_id, customer.full_name, customer.utility_bill, customer.passport_photo, customer.valid_id, customer.email_address, customer.home_address, customer.phone_number, customer.register_date, account_type.type as 'account type', wallet.wallet_no
    FROM customer
    LEFT JOIN account_type ON account_type.acct_id = customer.acct_id
    LEFT JOIN wallet ON wallet.cust_id = customer.cust_id
    WHERE customer.cust_id = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(1, $cust_id, PDO::PARAM_INT);
    $stmt->execute();
    $cust_details = $stmt->fetch(PDO::FETCH_ASSOC);
    return $cust_details;
  }

  public function getAll()
  {
    $sql = "SELECT * FROM customer";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute();
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $customers;
  }

  public function customer_update($full_name, $email_address, $home_address, $phone_number, $utility_bill, $passport_photo, $valid_id, $cust_id)
  {
    $sql = "UPDATE customer SET full_name = ?, email_address = ?, home_address = ?, phone_number = ?, utility_bill = ?, passport_photo = ?, valid_id = ? WHERE cust_id = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(1, $full_name, PDO::PARAM_STR);
    $stmt->bindParam(2, $email_address, PDO::PARAM_INT);
    $stmt->bindParam(3, $home_address, PDO::PARAM_STR);
    $stmt->bindParam(4, $phone_number, PDO::PARAM_STR);
    $stmt->bindParam(5, $utility_bill, PDO::PARAM_STR);
    $stmt->bindParam(6, $passport_photo, PDO::PARAM_STR);
    $stmt->bindParam(7, $valid_id, PDO::PARAM_STR);
    $stmt->bindParam(8, $cust_id, PDO::PARAM_INT);

    $updated_record = $stmt->execute();
    echo "<script>alert('Profile Updated Successfully')</script>";
    //return $updated_record;
  }

}

$customer = new Customer();
// //echo $customer->customerReg('Seun Jacobs','seunlo@gmail.com','21, Adebare Street, Ikeja','08028348422','sexpjop0@');
//$all = $customer->change_password(8, 'ploty', 'plot');
// echo "<pre>";
// print_r($all);
//$wallet = $customer->retrieveCustomer(11);
//print_r($wallet);

?>

<!-- SELECT customer.cust_id, customer.full_name, customer.utility_bill, customer.passport_photo, customer.valid_id, customer.email_address, customer.home_address, customer.phone_number, customer.register_date, account_type.type as 'account type', wallet.wallet_no
FROM customer
JOIN account_type ON account_type.acct_id = customer.acct_id
JOIN wallet ON wallet.cust_id = customer.cust_id
WHERE customer.cust_id = 11; -->