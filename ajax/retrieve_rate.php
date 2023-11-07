<?php
require_once("../classes/Db.php");

$myDB = new Db();
$conn = $myDB->connect();
$loan_type_id = $_POST['loan_type'];
$sql = "SELECT * FROM loan_rate WHERE loan_type_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bindParam(1, $loan_type_id, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$rate = $row["rate"];

echo $rate;
exit();
?>