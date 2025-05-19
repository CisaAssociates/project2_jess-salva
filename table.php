<?php 

include './config.php';

$id = 102;
$sql = "DELETE FROM nodes WHERE node_id = :node_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":node_id",$id,PDO::PARAM_INT);
if($stmt->execute()){
 echo "deleted successfully";
}