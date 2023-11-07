<?php
include_once "Db.php";
class RandomNumber extends Db
{
  public function generateNumber($length = 5)
  {
    $numbers = range('0', '9');
    $final_array = $numbers;

    $account_number = '';

    while ($length--) {
      $key = array_rand($final_array);
      $account_number .= $final_array[$key];
    }
    return $account_number;
  }
}

// $number = new RandomNumber();
// echo $account_num = $number->generateNumber(6);
// echo $account_num;
?>