<?php
require_once "Db.php";
class Account extends Db
{
  public function add_Account($type)
  {
    $sql = "INSERT INTO account_type(type) VALUES(?)";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(1, $type, PDO::PARAM_STR);
    $stmt->execute();
    echo "<script>alert('Account Type added successfully')</script>";
  }
  public function fetch_all_account_type()
  {
    $sql = "SELECT * FROM account_type";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute();
    $category = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $category;
  }
}

$acctype = new Account();
?>