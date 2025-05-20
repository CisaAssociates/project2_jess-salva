<?php 

include "./config.php";

$sql = "SELECT n.*
FROM nodes n
JOIN (
    SELECT node_id, MAX(id) AS latest_id
    FROM nodes
    GROUP BY node_id
) latest_entry
ON n.node_id = latest_entry.node_id AND n.id = latest_entry.latest_id;";
$stmt = $conn->prepare($sql);
$stmt->execute();
$res = $stmt->fetchAll(PDO::FETCH_ASSOC);

print_r($res);