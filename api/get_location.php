<?php
// File: latest-nodes.php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Add these headers to prevent caching on the client side and by proxies
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // A date in the past

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