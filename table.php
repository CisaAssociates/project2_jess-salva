<?php

include './config.php';

$sql = "SELECT n.*
            FROM nodes n
            JOIN (
                SELECT node_id, MAX(datetime) AS latest_time
                FROM nodes
                GROUP BY node_id
            ) latest
            ON n.node_id = latest.node_id AND n.datetime = latest.latest_time";

$stmt = $conn->prepare($sql);
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($results);
