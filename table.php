<?php 

include './config.php';

try{
    $node_id = 101;
    $sql = "DELETE FROM nodes WHERE node_id = :node_id ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":node_id",$node_id,PDO::PARAM_INT);
    $stmt->execute();

}catch(PDOException $e){
    echo "Message".$e->getMessage();
}