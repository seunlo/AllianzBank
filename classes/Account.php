<?php
require_once "Db.php";

class Account extends Db
{

  public function add_Account($type)
  {
    //check if email is in db before
    $sql = "SELECT * FROM account_type WHERE type = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(1, $type, PDO::PARAM_STR);
    $stmt->execute();
    $category_count = $stmt->rowCount();
    //if $category_count is greater than zero it means the category already exist in the db
    if ($category_count > 0) {
      echo "<script>alert('Account Type is already registered')</script>";
      exit();
    } else {

      //category does not exist to get to this line, so insert into db
      $sql = "INSERT INTO account_type(type) VALUES(?)";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(1, $type, PDO::PARAM_STR);
      $stmt->execute();
      echo "<script>alert('Account Type added successfully')</script>";
    }
  }


  public function delete_category($acct_id)
  {

    $sql = "SELECT * FROM account_type WHERE acct_id = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(1, $acct_id, PDO::PARAM_INT);
    $stmt->execute();

    $del_count = $stmt->rowCount();
    if ($del_count < 1) { //it doesnt exist
      return false;
    } else {

      $sql = "DELETE FROM account_type WHERE acct_id = ?";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(1, $acct_id, PDO::PARAM_INT);

      $stmt->execute();
      echo "<script>alert('Account Type Deleted Successfully')</script>";
    }
  }

  public function get_account_type_detail($acct_id)
  {
    $sql = "SELECT * FROM  account_type WHERE acct_id = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindparam(1, $acct_id, PDO::PARAM_INT);
    $stmt->execute();
    $count = $stmt->rowCount(); //count how many records have the id.
    //Count < 1 means no record with that id.
    if ($count < 1) {
      return false;
      exit();
    } else {
      //This mean the book exist, so we fetch it and return it
      $book = $stmt->fetch(PDO::FETCH_ASSOC);
      return $book;
    }

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
//echo $acctype->add_Account("Flexi");
//echo $cat->update_category(1, 'ojata');
//echo $cat->delete_category(1);
// $all_cat = $cat->fetch_all_category();
// echo "<pre>";
// print_r($all_cat);
// $specific_category = $acctype->fetch_all_account_type();
// echo "<pre>";
// print_r($specific_category);


?>