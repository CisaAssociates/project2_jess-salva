<?php 

include './config.php';

try{
    

}catch(PDOException $e){
    echo "Message".$e->getMessage();
}