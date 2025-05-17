<?php
// Database connection parameters
include '../config.php';

// Set headers to allow cross-origin resource sharing if needed
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Get raw POST data
$data = json_decode(file_get_contents("php://input"), true);

// Function to log errors/messages to a file
function logMessage($message) {
    $logFile = 'lora_api_log.txt';
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$timestamp] $message" . PHP_EOL, FILE_APPEND);
}

// Check if required data exists
if (
    isset($data['node_id']) && 
    isset($data['latitude']) && 
    isset($data['longitude']) &&
    isset($data['state'])&&
    isset($data['node_name'])
) {
    try {
        
        $now = new DateTime("now", new DateTimeZone('Asia/Manila'));
        $date = $now->format('Y-m-d h:i:s A');

        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Prepare SQL statement
        $sql = "INSERT INTO nodes (node_id,node_name, latitude, longitude, state, datetime) 
                VALUES (:node_id, :node_name ,:latitude, :longitude, :state, :datetime)";
        
        $stmt = $conn->prepare($sql);
        
        // Bind parameters
        $stmt->bindParam(':node_id', $data['node_id'], PDO::PARAM_INT);
        $stmt->bindParam(':node_name',$data['node_name'],PDO::PARAM_STR);
        $stmt->bindParam(':latitude', $data['latitude'], PDO::PARAM_STR);
        $stmt->bindParam(':longitude', $data['longitude'], PDO::PARAM_STR);
        $stmt->bindParam(':state', $data['state'], PDO::PARAM_INT);
        $stmt->bindParam(':datetime', $date, PDO::PARAM_STR);
        
        // Execute the statement
        $stmt->execute();
        
        // Respond with success
        http_response_code(201); // Created
        echo json_encode(array(
            "status" => "success",
            "message" => "Location data saved successfully",
            "data" => array(
                "node_id" => $data['node_id'],
                "latitude" => $data['latitude'],
                "longitude" => $data['longitude'],
                "state" => $data['state'],
                "timestamp" => date('Y-m-d H:i:s')
            )
        ));
        
        logMessage("Data successfully inserted for node " . $data['node_id']);
    }
    catch(PDOException $e) {
        // Database error
        http_response_code(500); // Internal Server Error
        echo json_encode(array(
            "status" => "error",
            "message" => "Database error: " . $e->getMessage()
        ));
        logMessage("Database error: " . $e->getMessage());
    }
} else {
    // Missing required data
    http_response_code(400); // Bad Request
    echo json_encode(array(
        "status" => "error",
        "message" => "Missing required data. Please provide node_id, latitude, longitude, and state."
    ));
    logMessage("Missing required data in request: " . json_encode($data));
}
?>