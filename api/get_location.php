<?php
// File: latest-nodes.php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

include "../config.php";

try {
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

    echo json_encode([
        "status" => "success",
        "data" => $results
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
