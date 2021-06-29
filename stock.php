<?php


//list of all pending order
//http://localhost/newroz/task3/stock.php?list=pending

//status change of delivered product
//status =1 means product delivered,0 means product order pending

//http://localhost/newroz/task3/stock.php?status=1&orderid=be31590

//stock quantity updated of failure delivery

//http://localhost/newroz/task3/stock.php?stockupdate=1&orderid=be31590




$conn = new mysqli("localhost", "root", "", "newroz_task");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



if(isset($_REQUEST['list'])&&isset($_REQUEST['list'])=='pending'){


$sql = "SELECT * FROM product_order WHERE status=0";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {


      $response=array('name'=>$row['name'],'orderid'=>$row['orderid'],'mobileno'=>$row['mobile_no'],'address'=>$row['address'],'deliverycharge'=>$row['charge']);
     
      echo json_encode($response);
      echo '<br/>';
      
    }
} else {

  $response='No product available';
     
  echo json_encode($response);
  
   
}


}

if(isset($_REQUEST['status']) && isset($_REQUEST['orderid'])){

    $status=$_REQUEST['status'];
    $orderid=$_REQUEST['orderid'];

    $sql = "UPDATE product_order SET status='$status' WHERE orderid='$orderid'";

    if ($conn->query($sql) === TRUE) {
      
      $response='product order deliver status updated';
      http_response_code(200);
      echo json_encode($response);

    } else {
      echo "Error updating record: " . $conn->error;
    }
    
    }


    
if(isset($_REQUEST['stockupdate']) && isset($_REQUEST['orderid'])){

    $stockupdate=$_REQUEST['stockupdate'];
    $orderid=$_REQUEST['orderid'];


    $sql = "SELECT name FROM product_order WHERE orderid='$orderid' LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
     
      while($row = $result->fetch_assoc()) {
        
        $name=$row['name'];

      }
    }
    else {
       
  
    }

    $sql = "UPDATE product SET stock=stock+$stockupdate WHERE name='$name'";

    if ($conn->query($sql) === TRUE) {
      $response='product stock updated';
      http_response_code(200);
      echo json_encode($response);
    } else {
      echo "Error updating record: " . $conn->error;
    }
    
    }



$conn->close();
?>