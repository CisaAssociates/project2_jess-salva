<?php 

include "./config.php";

$sql = "SELECT * FROM nodes ";
$stmt = $conn->prepare($sql);
$stmt->execute();
$res = $stmt->fetchAll(PDO::FETCH_ASSOC);

print_r($res);