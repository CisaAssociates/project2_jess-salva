<?php 

include "./config.php";

$sql = "SELECT * FROM nodes ";
$stmt = $conn->prepare($sql);
$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($res);