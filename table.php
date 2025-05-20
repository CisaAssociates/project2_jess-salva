<?php 

include "./config.php";

$sql = "SELECT * FROM nodes ";
$stmt = $conn->prepare($sql);
$res = $stmt->execute();
print_r($res);