<?php 

include "./config.php";

$sql = "SELECT id, node_id, datetime, node_name, latitude, longitude, state
FROM nodes
WHERE node_id = 101
ORDER BY datetime DESC
LIMIT 5; -- Or a larger number to see recent history ";
$stmt = $conn->prepare($sql);
$stmt->execute();
$res = $stmt->fetchAll(PDO::FETCH_ASSOC);

print_r($res);