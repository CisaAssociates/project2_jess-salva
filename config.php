<?php 

$host = "localhost";
$username = "u347279731_pj2_jess_salva";
$password = "Project2_2025";
$db = "u347279731_pj2_jess_salva";

try{
    $conn = new PDO("mysql:host=$host;dbname=$db",$username,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    
}catch(PDOException $e){
    echo "Connection Failed".$e->getMessage();
}
