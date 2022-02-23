<?php 
require_once (__DIR__.'/config.php');

$request = $_REQUEST;

if(is_array($request) && !empty($request) && isset($request["_feedback"])){
    
    $rating = $mysqli->real_escape_string($request["rating"]);
    $reason = $mysqli->real_escape_string($request["reason"]);
    $sql = "INSERT INTO feedback (reason, rating, store_id)
    VALUES ('{$reason}',{$rating}, NULL)";
    
    if ($mysqli->query($sql) === TRUE) {
      echo 1;
    } else {
         echo 0;
    }
    

exit();
}

function getReportTwoDate($from,$to,$mysqli){
  $gettingSTroe =  "select * from store";
    $al_store = $mysqli->query( $gettingSTroe);



    
 $sql =  "SELECT count(feedback.store_id) as total,
 store.name as store,
 sending_message_log.no_of_message_send
FROM feedback 
LEFT JOIN store
ON feedback.store_id=store.id
LEFT JOIN sending_message_log
ON sending_message_log.store_id=store.id
WHERE DATE(feedback.created_at) BETWEEN '$from' AND '$to'
AND 
DATE(sending_message_log.sending_date) BETWEEN '$from' AND '$to'
GROUP BY store.id
ORDER BY store.id ASC";
  $result = $mysqli->query( $sql);
  $data = [];

  $listing = array();



   foreach($result as $store_with_data)
   {
    
       $data[$store_with_data['store']] = (int)$store_with_data['total'];
       $listing[$store_with_data['store']] = array(
         "total"=>(int)$store_with_data['total'],
         "no_of_message_send"=>(int)$store_with_data['no_of_message_send'],
       );
   }
 

 foreach($al_store as $one_store)
 {
   if(!array_key_exists($one_store['name'],$data)){
    $data[$one_store["name"]] = 0;  
    $listing[$one_store["name"]] = array(
      "total"=>0,
      "no_of_message_send"=>getSendingMessageLogWithStoreBase((int)$one_store['id'],$mysqli),
    );  
   }

   

 }
 ksort($listing);
ksort($data);

return array($data,$listing);
}

function getSendingMessageLogWithStoreBase($id,$mysqli){
  $query = $mysqli->query("SELECT no_of_message_send FROM sending_message_log WHERE `store_id` = {$id} ");
  while ($row = $query->fetch_array()) {
    return $row["no_of_message_send"]; 
  }
}


if (is_array($request) && !empty($request) && isset($request["reporting"])) {
    
   $m1_from =   $request["m1_from"];
   $m1_to =   $request["m1_to"];
   $m2_from =   $request["m2_from"];
   $m2_to =   $request["m2_to"];
   $data =  $data1 = array(); 
   if(!empty($m1_from) && !empty($m1_to)){  
    $data = getReportTwoDate($m1_from,$m1_to,$mysqli);
    $M1 = date("M jS",strtotime($m1_from))." - ". date("M jS",strtotime($m1_to));
   }
   if(!empty($m2_from) && !empty($m2_to)){
    $data1 = getReportTwoDate($m2_from,$m2_to,$mysqli); 
    $M2 = date("M jS",strtotime($m2_from))." - ". date("M jS",strtotime($m2_to));
  }

  $listing = array("M1"=>$data[1],"M2"=>$data1[1]);
  $chart = array(
    'labels' => array_keys($data[0]),
    'datasets' => array(
        array(
            'label' => $M1,
            'backgroundColor' => 'rgba(23,205,239,0.5)',
            'borderColor' => '#17cdef',
            'borderWidth' => 1,
            'data' => array_values($data[0]),
        ),
        array(
            'label' =>   $M2,
            'backgroundColor' => 'rgba(46,206,137,0.5)',
            'borderColor' => '#2ece89',
            'borderWidth' => 1,
            'data' => array_values($data1[0]),
        )
    )
);


  echo json_encode(array($chart,$listing,$M1,$M2));
  
  

  

exit();
}





if(!empty($request["listing"])){
    $query = $mysqli->query("SELECT sending_message_log.id,store.name as store_name,sending_message_log.no_of_message_send as no_of_message_send,sending_message_log.sending_date as sending_date FROM `sending_message_log` inner join  store on store.id = sending_message_log.store_id");
    while ($row = $query->fetch_array()) {
        $data[] = array(
          "id" => $row['id'],
          "store_name" => $row['store_name'],
          "no_of_message_send" => $row['no_of_message_send'],
          "sending_date" => $row['sending_date'],
          "action" => '<a class="edit_data btn btn-sm  btn-primary"  data-id="'.$row["id"].'">Edit</a><a class="btn btn-sm  delete_data btn-danger"  data-id="'.$row["id"].'">Delete</a>'
        );
    }
    echo json_encode(array("data"=>!empty($data)? $data : array()));


  
exit();
  }



if (is_array($request) && !empty($request) && isset($request["edit_message"])) {
  $id = $request["id"];
  $query = $mysqli->query("SELECT * FROM `sending_message_log` where id = '{$id}'");
  if($query){
      $resp['status'] = 'success';
      $resp['data'] = $query->fetch_array();
  }else{
      $resp['status'] = 'success';
      $resp['error'] =  $mysqli->error;
  }
  echo json_encode($resp);


  
exit();
}


if (is_array($request) && !empty($request) && isset($request["delete_message"])) {
  $id = $request["id"];
  $delete = $mysqli->query("DELETE FROM `sending_message_log` where id = '{$id}'");
  if($delete){
      $resp['status'] = 'success';
  }else{
      $resp['status'] = 'failed';
      $resp['msg'] = $mysqli->error;
  }
  
  echo json_encode($resp);


  
exit();
}


if (is_array($request) && !empty($request) && isset($request["add_message"])) {
  $query = $mysqli->query("INSERT INTO `sending_message_log` (`store_id`,`no_of_message_send`,`sending_date`) 
  VALUE ('{$request["store_id"]}','{$request["no_of_message_send"]}','{$request["sending_date"]}')");
  if($query){
      $resp['status'] = 'success';
  }else{
      $resp['status'] = 'failed';
      $resp['msg'] = $mysqli->error;
  }
  
  echo json_encode($resp);

  
exit();
}

if (is_array($request) && !empty($request) && isset($request["update_message"])) {
  $id = $request["id"];
  $storeId = $request["store_id"];
  $no_of_message_send = $request["no_of_message_send"];
  $sending_date = $request["sending_date"];
  $update = $mysqli->query("UPDATE `sending_message_log` set `store_id` = '{$storeId}', `no_of_message_send` = '{$no_of_message_send}', `sending_date` = '{$sending_date}' where id = '{$id}'");
  if($update){
      $resp['status'] = 'success';
  }else{
      $resp['status'] = 'failed';
      $resp['msg'] = $mysqli->error;
  }
  
  echo json_encode($resp);

  
exit();
}










    $mysqli->close();
?>