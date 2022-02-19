<?php 
require_once (__DIR__.'/config.php');

$request = $_REQUEST;

if(is_array($request) && !empty($request) && isset($request["_feedback"])){
    
    $rating = $mysqli->real_escape_string($request["rating"]);
    $reason = $mysqli->real_escape_string($request["reason"]);
    if(!empty($rating) && $rating >=4){
       echo  0;
       exit();
    }



    $sql = "INSERT INTO feedback (reason, rating, store_id)
    VALUES ('{$reason}',{$rating}, NULL)";
    
    if ($mysqli->query($sql) === TRUE) {
      echo 1;
    } else {
         echo 0;
    }
    
    $mysqli->close();
exit();
}
?>